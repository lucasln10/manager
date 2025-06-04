import React from 'react';
import PropTypes from 'prop-types';

const MainLayout = ({ children }) => {
    return (
        <div className="min-h-screen bg-gray-50">
            <header className="bg-white shadow-sm">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between h-16 items-center">
                        <div className="flex-shrink-0">
                            <h1 className="text-xl font-bold text-primary">Meu App</h1>
                        </div>
                        <nav className="flex space-x-4">
                            <a href="/" className="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium">
                                Home
                            </a>
                            <a href="/perfil" className="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium">
                                Perfil
                            </a>
                        </nav>
                    </div>
                </div>
            </header>

            <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                {children}
            </main>

            <footer className="bg-white border-t">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <p className="text-center text-gray-500 text-sm">
                        © {new Date().getFullYear()} Meu App. Todos os direitos reservados.
                    </p>
                </div>
            </footer>
        </div>
    );
};

MainLayout.propTypes = {
    children: PropTypes.node.isRequired
};

export default MainLayout; 