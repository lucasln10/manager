import React, { useState, useCallback } from 'react';
import { debounce } from 'lodash';
import Button from '../components/common/Button';
import Input from '../components/common/Input';
import SearchComponent from '../components/common/SearchComponent';
import MainLayout from '../components/layout/MainLayout';

export default function SearchComponent({ initialSearch }) {
    const [search, setSearch] = useState(initialSearch || '');
    const [isLoading, setIsLoading] = useState(false);

    const debouncedSearch = useCallback(
        debounce((value) => {
            // sua lógica de busca aqui
        }, 300),
        []
    );

    const handleChange = (e) => {
        let v = e.target.value;

        if (/^\d*$/.test(v)) {
            v = v.replace(/(\d{3})(\d)/, '$1.$2');
            v = v.replace(/(\d{3})(\d)/, '$1.$2');
            v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        }

        if (v.length > 30) return;

        setSearch(v);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        const params = new URLSearchParams(window.location.search);
        params.set('search', search);
        window.location.href = window.location.pathname + '?' + params.toString();
    };

    return (
        <form onSubmit={handleSubmit} className="flex flex-wrap gap-2 items-center">
            <input 
                type="text"
                value={search}
                onChange={handleChange}
                placeholder="Buscar por nome ou CPF"
                maxLength={30}
                autoComplete="off"
                aria-label="Campo de busca"
                role="searchbox"
                className="w-full sm:w-auto flex-grow px-4 py-2 border border-gray-300 bg-white text-black rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
            />
            <button 
                type="submit" 
                className="bg-primary hover:bg-primary-light text-white font-semibold px-4 py-2 rounded-md transition-all duration-200 ease-in-out transform hover:scale-105"
            >
                <span className="flex items-center gap-2">
                    <svg className="w-5 h-5" />
                    Buscar
                </span>
            </button>
        </form>
    );
}