import React from 'react';
import PropTypes from 'prop-types';

const Input = ({
    label,
    error,
    className = '',
    ...props
}) => {
    return (
        <div className="w-full">
            {label && (
                <label className="block text-sm font-medium text-gray-700 mb-1">
                    {label}
                </label>
            )}
            <input
                className={`
                    w-full px-4 py-2 
                    border border-gray-300 
                    bg-white text-black 
                    rounded-md 
                    focus:outline-none focus:ring-2 focus:ring-primary 
                    transition-all duration-200
                    ${error ? 'border-red-500' : ''}
                    ${className}
                `}
                {...props}
            />
            {error && (
                <p className="mt-1 text-sm text-red-500">
                    {error}
                </p>
            )}
        </div>
    );
};

Input.propTypes = {
    label: PropTypes.string,
    error: PropTypes.string,
    className: PropTypes.string
};

export default Input; 