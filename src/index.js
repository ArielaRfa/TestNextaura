import React from "react"
import ReactDOM from "react-dom/client"
import {BrowserRouter} from "react-router-dom"
import App from "./App"

import "./web/style/index.css"
import "./web/style/colors.css"

function Root() {
    return <BrowserRouter>
        <App/>
    </BrowserRouter>
}

/* ============================== Main Code ============================== */
const root = ReactDOM.createRoot(document.getElementById("root"))
root.render(<Root/>)
