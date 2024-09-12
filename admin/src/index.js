import React from 'react';
import ReactDOM from 'react-dom';
import './style.css';
import AdminPage from "./components/AdminPage";

function App() {
    return <AdminPage/>;
}

ReactDOM.render(<App/>, document.getElementById('wordmix-admin-app'));