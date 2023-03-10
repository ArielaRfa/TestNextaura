import FrontRoutes from "./services/FrontRoutes"
import Header from "./components/general/Header"
import {Session} from "./services/SessionHelper"

/* ----- FontAwesome icons import ----- */
import {library} from "@fortawesome/fontawesome-svg-core"
import {fas} from "@fortawesome/free-solid-svg-icons"
import {far} from "@fortawesome/free-regular-svg-icons"
import {fab} from "@fortawesome/free-brands-svg-icons"

library.add(fas, far, fab)

export default function App() {
    const user = Session.getSessionUser()
    return <section className="app-section">
        <header className="header">
            <Header isLogged={Session.isLoggedIn()} user={user}/>
        </header>
        <article className="content">
            <FrontRoutes/>
        </article>
        <footer className="footer flex-start">
            <div className="footer-version">Version {process.env.REACT_APP_VERSION}</div>
        </footer>
    </section>

}