import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App'; // componente principal que você criou

import '../css/app.css'; // importa Tailwind ou CSS customizado

const rootElement = document.getElementById('react-root');

if (rootElement) {
    const root = ReactDOM.createRoot(rootElement);
    root.render(
        <React.StrictMode>
            <App />
        </React.StrictMode>
    );
}