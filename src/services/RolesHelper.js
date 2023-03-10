import {ROLE_ADMIN, ROLE_USER} from "./Constants"
import _ from "lodash"

/**
 *
 * @param role {string}
 * @param minRole {string}
 * @return boolean
 */
function isGranted(role, minRole = ROLE_USER) {
    if (minRole === ROLE_ADMIN) {
        return _.includes([ROLE_ADMIN], role)
    }
    if (minRole === ROLE_USER) {
        return _.includes([ROLE_ADMIN, ROLE_USER], role)
    }
}

function getRoleString(role) {
    const roleStrings = {
        [ROLE_ADMIN]: "Administrateur",
        [ROLE_USER]: "Utilisateur"
    }

    return _.get(roleStrings, role)
}

export const Roles = {isGranted, getRoleString}
