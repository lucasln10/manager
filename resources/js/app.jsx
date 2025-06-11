import React from 'react';
import { createRoot } from 'react-dom/client';
import SearchComponent from './components/SearchComponent';

const el = document.getElementById('search-component');
if (el) {
  const initialSearch = el.getAttribute('data-search');
  createRoot(el).render(<SearchComponent initialSearch={initialSearch} />);
}
