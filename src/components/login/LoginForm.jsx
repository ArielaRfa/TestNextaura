import React from "react"
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome"
import requestApi from "../../services/ApiService"
import {Session} from "../../services/SessionHelper"
import {
    HTTP_INVALID_PASSWORD,
    HTTP_INVALID_TOKEN,
    HTTP_TOKEN_EXPIRED,
    HTTP_USER_NOT_FOUND
} from "../../services/Constants"

import "./loginForm.css"

export default class LoginForm extends React.Component {
    static defaultProps = {
        onLogin: () => {
            console.log("Logged in !")
        }
    }

    constructor(props) {
        super(props)
        this.state = {
            loading: false,
            identifier: "",
            password: "",
            error: {
                status: false,
                message: ""
            }
        }
        this._handleSubmit = this._handleSubmit.bind(this)
        this._handlePasswordChange = this._handlePasswordChange.bind(this)
        this._handleIdentifierChange = this._handleIdentifierChange.bind(this)
    }

    async _handleSubmit(e) {
        e.preventDefault()
        if (this.state.identifier === "" || this.state.password === "") {
            this.setState({
                error: {
                    status: true,
                    message: "Identifiant et mot de passe requis"
                }
            })
        } else {
            this.setState({loading: true})
            requestApi("/user/login", "POST", {
                identifier: this.state.identifier,
                password: this.state.password
            }).then(response => {
                if (response.status === 200) {
                    const data = response.data
                    const user = {
                        id: data.id,
                        email: data.email,
                        name: data.name,
                        surname: data.surname,
                        role: data.roles
                    }
                    Session.handleLogin({user: user, jwtToken: data.token, refreshToken: data.refreshToken})
                this.props.onLogin()
                } else {
                    let message
                    if (response.code === HTTP_USER_NOT_FOUND) {
                        message = "Identifiant inconnu"
                    } else if (response.code === HTTP_INVALID_PASSWORD) {
                        message = "Mot de passe incorrect"
                    } else if (response.code === HTTP_INVALID_TOKEN) {
                        message = "Token non valide, veuillez réessayer"
                    } else if (response.code === HTTP_TOKEN_EXPIRED) {
                        message = "Token expiré, veuillez réessayer"
                    } else {
                        message = response.message
                    }
                    this.setState({
                        error: {
                            status: true,
                            message: message
                        }
                    })
                }
                this.setState({loading: false})
            }).catch((error) => {
                console.log(error)
                this.setState({loading: false})
            })

        }
    }

    _handleIdentifierChange(e) {
        this.setState({
            identifier: e.target.value,
            error: {status: false}
        })
    }

    _handlePasswordChange(e) {
        this.setState({
            password: e.target.value,
            error: {status: false}
        })
    }

    render() {

        return <div className="login flex">
            {this.state.loading && <Loading/>}
            <form onSubmit={this._handleSubmit} className="login-form flex">
                {this.state.error.status &&
                    <p className="login-error">{this.state.error.message}</p>
                }
                <input type="text" name="identifier" value={this.state.identifier} required={true}
                            onChange={this._handleIdentifierChange} placeholder="Identifiant"/>
                <input type="password" name="password" value={this.state.password} required={true}
                            onChange={this._handlePasswordChange} placeholder="Mot de passe"/>

                <button type="submit" name="loginButton" className="login-button">
                    Connexion
                </button>
            </form>

        </div>
    }
}

export function Loading() {
    return <div className="loading">
        <div className="loading-content">
            <FontAwesomeIcon icon="fas fa-gear loading-icon" spin/>
        </div>
    </div>
}
