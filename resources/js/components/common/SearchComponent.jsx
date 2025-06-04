import React, { useState, useCallback, memo } from 'react';
import { debounce } from 'lodash';
import PropTypes from 'prop-types';

const SearchComponent = memo(({ 
    initialSearch, 
    placeholder = "Buscar por nome ou CPF",
    maxLength = 30,
    onSearch,
    className = ""
}) => {
    const [search, setSearch] = useState(initialSearch || '');
    const [isLoading, setIsLoading] = useState(false);

    const handleChange = useCallback((e) => {
        let v = e.target.value;

        if (/^\d*$/.test(v)) {
            v = v.replace(/(\d{3})(\d)/, '$1.$2');
            v = v.replace(/(\d{3})(\d)/, '$1.$2');
            v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        }

        if (v.length > maxLength) return;

        setSearch(v);
        if (onSearch) {
            onSearch(v);
        }
    }, [maxLength, onSearch]);

    const handleSubmit = useCallback(async (e) => {
        e.preventDefault();
        setIsLoading(true);
        
        try {
            const params = new URLSearchParams(window.location.search);
            params.set('search', search);
            window.location.href = window.location.pathname + '?' + params.toString();
        } finally {
            setIsLoading(false);
        }
    }, [search]);

    return (
        <form 
            onSubmit={handleSubmit} 
            className={`flex flex-wrap gap-2 items-center w-full ${className}`}
        >
            <div className="relative flex-grow">
                <input 
                    type="text"
                    value={search}
                    onChange={handleChange}
                    placeholder={placeholder}
                    maxLength={maxLength}
                    autoComplete="off"
                    aria-label="Campo de busca"
                    role="searchbox"
                    className="w-full px-4 py-2 border border-gray-300 bg-white text-black rounded-md focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-200"
                />
                {isLoading && (
                    <div className="absolute right-3 top-1/2 transform -translate-y-1/2">
                        <div className="animate-spin rounded-full h-5 w-5 border-b-2 border-primary"></div>
                    </div>
                )}
            </div>
            <button 
                type="submit" 
                disabled={isLoading}
                className="bg-primary hover:bg-primary-light text-white font-semibold px-4 py-2 rounded-md transition-all duration-200 ease-in-out transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <span className="flex items-center gap-2">
                    <svg 
                        className="w-5 h-5" 
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >
                        <path 
                            strokeLinecap="round" 
                            strokeLinejoin="round" 
                            strokeWidth={2} 
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" 
                        />
                    </svg>
                    Buscar
                </span>
            </button>
        </form>
    );
});

SearchComponent.propTypes = {
    initialSearch: PropTypes.string,
    placeholder: PropTypes.string,
    maxLength: PropTypes.number,
    onSearch: PropTypes.func,
    className: PropTypes.string
};

SearchComponent.displayName = 'SearchComponent';

export default SearchComponent; 