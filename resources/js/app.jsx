import React from 'react';
import { createRoot } from 'react-dom/client';
import ProductList from './components/ProductList';

const root = document.getElementById('app');
if (root) {
    createRoot(root).render(<ProductList />);
}
