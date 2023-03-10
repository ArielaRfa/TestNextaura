<?php

namespace App\Manager;

use App\Entity\User;
use App\Enum\HttpCodes;
use App\Exception\BaseException;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Gesdinet\JWTRefreshTokenBundle\Generator\RefreshTokenGeneratorInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;

/**
 * UserManager class
 */
class UserManager extends BaseManager
{
    private UserRepository|EntityRepository $userRepository;
    private UserPasswordHasherInterface $passwordHasher;
    private JWTTokenManagerInterface $JWTManager;
    private RefreshTokenGeneratorInterface $refreshTokenGenerator;
    private ParameterBagInterface $parameters;

    /**
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordHasherInterface $passwordHasher
     * @param JWTTokenManagerInterface $JWTManager
     * @param RefreshTokenGeneratorInterface $refreshTokenGenerator
     * @param ParameterBagInterface $parameters
     * @param Security $security
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        JWTTokenManagerInterface $JWTManager,
        RefreshTokenGeneratorInterface $refreshTokenGenerator,
        ParameterBagInterface $parameters,
        Security $security
    ) {
        parent::__construct($entityManager, User::class, $security);
        $this->userRepository = $this->repository;
        $this->passwordHasher = $passwordHasher;
        $this->JWTManager = $JWTManager;
        $this->refreshTokenGenerator = $refreshTokenGenerator;
        $this->parameters = $parameters;
    }

    /**
     * Between 8 and 20 characters, with lowercase, uppercase, number and symbols
     *
     * @param string $password
     * @return bool
     */
    public function verifyPassword(string $password): bool
    {
        return (bool)preg_match("#^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).*$#", $password);
    }

    /**
     * @param string $email
     * @return bool
     */
    public function verifyEmail(string $email): bool
    {
        return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param string $email
     * @return bool
     */
    public function isEmailAlreadyExist(string $email): bool
    {
        $users = $this->findAll();

        foreach ($users as $user) {
            if ($email === $user->getEmail()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param User $user
     * @param string $email
     * @return bool
     */
    public function isEmailAlreadyExistOutOfSelf(User $user, string $email): bool
    {
        $users = $this->findAll();

        foreach ($users as $anotherUser) {
            if ($email === $anotherUser->getEmail() && $user->getId() !== $anotherUser->getId()) {
                return true;
            }
        }

        return false;
    }


    /**
     * @param string $identifier
     * @param string $password
     * @return array
     * @throws BaseException
     */
    public function authenticateAndGenerateToken(string $identifier, string $password): array
    {
        $user = $this->findUserByIdentifier($identifier);

        if (!isset($user)) {
            throw new BaseException(
                ['identifier' => $identifier],
                "Erreur : Identifiant inconnu",
                HttpCodes::USER_NOT_FOUND->value
            );
        }

        if (!$this->passwordHasher->isPasswordValid($user, $password)) {
            throw new BaseException(
                ['identifier' => $identifier, 'password' => $password],
                "Erreur : Mot de passe invalide",
                HttpCodes::INVALID_PASSWORD->value
            );
        }

        $token = $this->JWTManager->create($user);
        $expirationDate = $this->JWTManager->parse($token)['exp'];
        $refreshToken = $this->refreshTokenGenerator->createForUserWithTtl(
            $user,
            $this->parameters->get('gesdinet_jwt_refresh_token.ttl')
        );

        $user->setApiRefreshToken($refreshToken->getRefreshToken());
        $user->setApiRefreshTokenExpiration($refreshToken->getValid());
        $this->persistAndFlush($user);

        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'name' => $user->getName(),
            'surname' => $user->getSurname(),
            'roles' => $user->getRoles(),
            'token' => $token,
            'expiration' => $expirationDate,
            'refreshToken' => $user->getApiRefreshToken(),
            'refreshTokenExpiration' => $user->getApiRefreshTokenExpiration()->getTimestamp()
        ];
    }

    /**
     * @param User $user
     * @return array
     */
    public function refreshToken(User $user): array
    {
        $token = $this->JWTManager->create($user);
        $expirationDate = $this->JWTManager->parse($token)['exp'];

        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'token' => $token,
            'expiration' => $expirationDate
        ];
    }

    /**
     * @param User $user
     * @return void
     */
    public function invalidateRefreshToken(User $user): void
    {
        $user->setApiRefreshToken(null);
        $user->setApiRefreshTokenExpiration(null);
        $this->persistAndFlush($user);
    }

    /**
     * @param string $identifier
     * @return User|null
     */
    public function findUserByIdentifier(string $identifier): ?User
    {
        return $this->findOneBy(["email" => $identifier]);
    }
}
