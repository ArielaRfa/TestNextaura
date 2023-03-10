import React from "react"
import DataTable from "react-data-table-component"
import {Session} from "../../services/SessionHelper"
import "./home.css"

//TODO: Ajouter un formulaire d'ajout
export default function HomePage() {
    return <section className="container">
        <Licences user={Session.getSessionUser()}/>
    </section>
}


class Licences extends React.Component {
    static defaultProps = {
        user: null
    }

    constructor(props) {
        super(props)

        this.state = {
            //TODO: Données en dur à modifier par un appel API
            licences: [
                {
                    "id": 1,
                    "label": "Clés Jetbrains",
                    "type": "Fichier clés",
                    "expirationDate": "15/06/2023",
                    "file": "https://picsum.photos/1600/900.jpg",
                    "total": 10,
                    "used": 10,
                    "contact": "sringot@nextaura.com",
                    "createdBy": "admin@test.com",
                    "createdAt": "20/02/2023 13:30"
                },
                {
                    "id": 2,
                    "label": "Zoho connect",
                    "type": "Abonnement",
                    "expirationDate": "31/12/2023",
                    "file": null,
                    "total": 20,
                    "used": 13,
                    "contact": "jmjacquot@nextaura.com",
                    "createdBy": "admin@test.com",
                    "createdAt": "20/02/2023 13:35"
                },
                {
                    "id": 3,
                    "label": "Swagger Hub - Administration",
                    "type": "Abonnement",
                    "expirationDate": "31/03/2023",
                    "file": null,
                    "total": 3,
                    "used": 3,
                    "contact": "jmjacquot@nextaura.com",
                    "createdBy": "admin2@test.com",
                    "createdAt": "20/02/2023 13:29"
                }
            ],
            totalRows: 3,
            perPage: 10
        }

        this._handlePerRowsChange = this._handlePerRowsChange.bind(this)
        this._handlePageChange = this._handlePageChange.bind(this)
    }

    _handlePerRowsChange(newPerPage) {
        this.setState({perPage: newPerPage})
    }

    _handlePageChange(page) {
        console.log(`page changed : ${page}`)
    }

    render() {
        const columns = [
            {name: "Identifiant", selector: row => row.id, sortable: true},
            {name: "Nom", selector: row => row.label, sortable: true},
            {name: "Type", selector: row => row.type, sortable: true},
            {name: "Date d'expiration", selector: row => row.expirationDate, sortable: true},
            {name: "Fichier", selector: row => row.file},
            {name: "Quantité", selector: row => row.total, sortable: true},
            {name: "Reste", selector: row => row.total - row.used, sortable: true},
            {name: "Contact", selector: row => row.contact}
        ]

        return <article className="licences flex">
            {this.props.user === null ?
                <LoginError/> :
                <>
                    <section className="flex-start title">
                        <h3>Licences disponibles chez Nextaura®</h3>
                    </section>

                    <section className="table card">
                        <div className="table-content">
                            {/* TODO: Ajouter un bouton de suppression dans le tableau */}
                            <DataTable
                                columns={columns}
                                data={this.state.licences}
                                fixedHeader
                                fixedHeaderScrollHeight="70vh"
                                highlightOnHover
                                pagination
                                paginationServer
                                paginationTotalRows={this.state.totalRows}
                                onChangeRowsPerPage={this._handlePerRowsChange}
                                onChangePage={this._handlePageChange}
                                responsive
                                className="licencesTable"
                                subHeaderAlign="center"
                                subHeaderWrap/>

                        </div>
                    </section>
                </>
            }
        </article>
    }
}

function LoginError() {
    return <section className="error flex card">
        <span> Veuillez vous connecter pour accéder aux informations de licence de Nextaura® </span>
        <div className="login-credentials flex">
            <span>Utilisateur : user@test.com/user</span>
            <span>Admin : admin@test.com/admin</span>
            <span>Admin : admin2@test.com/admin</span>
        </div>

    </section>
}