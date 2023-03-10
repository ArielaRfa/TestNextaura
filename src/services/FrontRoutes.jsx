import {Routes, Route} from "react-router-dom"
import HomePage from "../components/home/HomePage"
import ErrorPage from "../components/general/Error/ErrorPage"
import {routes as Routing} from "./RoutesHelper"

export default function FrontRoutes() {
    return <Routes>
        <Route path={Routing.app_home.path} element={<HomePage/>}/>
        <Route path="*" element={<ErrorPage code="404" title="Page non trouvée" message="Désolé, la page que vous essayez de charger n'existe pas"/>}/>
    </Routes>
}