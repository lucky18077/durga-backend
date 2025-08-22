import React, { useState, useEffect } from 'react';
import axios from 'axios';
import ReactDOM from 'react-dom/client';

function SubCategorySidebar({ categoryId, onSubCategorySelect, currentSubCategory }) {
    const [subCategories, setSubCategories] = useState([]);

    useEffect(() => {
        if (!categoryId) return;
        axios.get(`/api/subCategories?category_id=${categoryId}`)
            .then(res => setSubCategories(res.data || []))
            .catch(err => console.error(err));
    }, [categoryId]);

    return (
        <>
            <li>
                <a href="javascript:void(0);" onClick={() => onSubCategorySelect(null)}>
                    <div className="form-check ps-0 m-0 category-list-box">
                        <label className="form-check-label">
                            <span className={`main-category-item ${!currentSubCategory ? 'active' : ''}`}>
                                <img src="/cart.png" alt="All"
                                    style={{ width: 40, marginRight: 10, aspectRatio: '1/1', borderRadius: '50px' }} />
                                All
                            </span>
                        </label>
                    </div>
                </a>
            </li>
            {subCategories.map(sub => (
                <li key={sub.id}>
                    <a href="javascript:void(0);" onClick={() => onSubCategorySelect(sub.id)}>
                        <div className="form-check ps-0 m-0 category-list-box">
                            <label className="form-check-label">
                                <span className={`main-category-item ${currentSubCategory === sub.id ? 'active' : ''}`}>
                                    <img
                                        src={sub.image ? `/master images/${sub.image}` : '/cart.png'}
                                        alt={sub.name}
                                        style={{ width: 40, marginRight: 10, aspectRatio: '1/1', borderRadius: '50px' }}
                                    />
                                    {sub.name}
                                </span>
                            </label>
                        </div>
                    </a>
                </li>
            ))}
        </>
    );
}

export default function ProductList() {
    const [products, setProducts] = useState([]);
    const [currentCategory, setCurrentCategory] = useState(null);
    const [currentSubCategory, setCurrentSubCategory] = useState(null);
    const [loadingProductId, setLoadingProductId] = useState(null);

    const fetchProducts = (categoryId = null, subCategoryId = null) => {
        let url = '/apiProducts';
        const params = [];
        if (categoryId) params.push(`category_id=${categoryId}`);
        if (subCategoryId) params.push(`sub_category_id=${subCategoryId}`);
        if (params.length > 0) url += `?${params.join('&')}`;

        axios.get(url)
            .then(res => setProducts(res.data.data || []))
            .catch(err => console.error(err));
    };

    useEffect(() => {
        window.filterByCategory = (categoryId) => {
            setCurrentCategory(categoryId);
            setCurrentSubCategory(null);
            fetchProducts(categoryId, null);

            const sidebar = document.getElementById('subcategory-sidebar');
            if (sidebar) {
                const root = ReactDOM.createRoot(sidebar);
                root.render(
                    <SubCategorySidebar
                        categoryId={categoryId}
                        currentSubCategory={null}
                        onSubCategorySelect={(subId) => {
                            setCurrentSubCategory(subId);
                            fetchProducts(categoryId, subId);
                        }}
                    />
                );
            }
        };

        const urlParams = new URLSearchParams(window.location.search);
        const categoryFromUrl = urlParams.get('category_id');
        const subCategoryFromUrl = urlParams.get('sub_category_id');

        if (categoryFromUrl) {
            setCurrentCategory(parseInt(categoryFromUrl));
            if (subCategoryFromUrl) {
                setCurrentSubCategory(parseInt(subCategoryFromUrl));
            }
            fetchProducts(categoryFromUrl, subCategoryFromUrl);

            const sidebar = document.getElementById('subcategory-sidebar');
            if (sidebar) {
                const root = ReactDOM.createRoot(sidebar);
                root.render(
                    <SubCategorySidebar
                        categoryId={parseInt(categoryFromUrl)}
                        currentSubCategory={parseInt(subCategoryFromUrl) || null}
                        onSubCategorySelect={(subId) => {
                            setCurrentSubCategory(subId);
                            fetchProducts(parseInt(categoryFromUrl), subId);
                        }}
                    />
                );
            }
        } else {
            fetchProducts();
        }
    }, []);

    const updateCartQty = (productId, type) => {
        setLoadingProductId(productId);
        axios.post('/shopAddToCart', {
            product_id: productId,
            qtyType: type,
            _token: document.querySelector('meta[name="csrf-token"]').content
        }).then(() => fetchProducts(currentCategory, currentSubCategory))
            .finally(() => setLoadingProductId(null));
    };

    const handleAddToCart = (id) => {
        const userId = document.querySelector('meta[name="user-id"]')?.content;

        if (!userId) {
            const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            loginModal.show();
            return;
        }

        setLoadingProductId(id);
        axios.post('/shopAddToCart', {
            product_id: id,
            qty: 1,
            _token: document.querySelector('meta[name="csrf-token"]').content
        }).then(() => fetchProducts(currentCategory, currentSubCategory))
            .finally(() => setLoadingProductId(null));
    };

    return (
        <div className="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section">
            {products.map(item => (
                <div key={item.id} className="col mb-4">
                    <div className="product-box-3 h-100 wow fadeInUp shadow rounded-lg p-3 bg-white" data-wow-delay="0.05s">
                        <div className="product-header">
                            <div className="product-image">
                                <a href={`/product-details/${item.id}`}>
                                    <img
                                        src={`/product images/${item.image || 'cart.png'}`}
                                        alt={item.name}
                                        className="img-fluid blur-up lazyload w-100"
                                    />
                                </a>
                            </div>
                        </div>
                        <div className="product-footer mt-3">
                            <div className="product-detail">
                                <span className="span-name text-sm text-muted">{item.category}</span>
                                <a href={`/product-details/${item.id}`}>
                                    <h5 className="name mt-1">{item.name}</h5>
                                </a>
                                <h6 className="unit text-sm mb-1">{item.qty} {item.uom}</h6>
                                {item.base_price !== 0 && (
                                    <h6 className="unit text-sm text-gray-500">
                                        ₹ {item.base_price / item.qty} per {item.uom}
                                    </h6>
                                )}
                                <h5 className="price text-lg font-semibold text-primary">
                                    ₹ {item.base_price}
                                    {item.mrp > item.base_price && (
                                        <del className="text-muted ms-2">₹ {item.mrp}</del>
                                    )}
                                </h5>
                                {item.cart_qty > 0 ? (
                                    <div
                                        className="d-flex align-items-center justify-content-center mt-2"
                                        style={{
                                            border: '1px solid #e0e0e0',
                                            borderRadius: '999px',
                                            padding: '4px 8px',
                                            maxWidth: '140px',
                                            margin: '0 auto',
                                            background: '#fff',
                                             borderColor: 'black',
                                        }}
                                    >
                                        <button
                                            disabled={loadingProductId === item.id}
                                            onClick={() => updateCartQty(item.id, 'minus')}
                                            style={{
                                                border: 'none',
                                                backgroundColor: '#f5f5f5',
                                                color: '#333',
                                                borderRadius: '50%',
                                                width: '28px',
                                                height: '28px',
                                                fontWeight: 'bold',
                                                fontSize: '16px',
                                                lineHeight: '1',
                                                display: 'flex',
                                                alignItems: 'center',
                                                justifyContent: 'center',
                                                cursor: 'pointer',
                                                marginRight: '10px'
                                            }}
                                        >
                                            {loadingProductId === item.id ? (
                                                <span className="spinner-border spinner-border-sm text-secondary" />
                                            ) : (
                                                '-'
                                            )}
                                        </button>

                                        <span
                                            style={{
                                                minWidth: '24px',
                                                textAlign: 'center',
                                                fontSize: '14px',
                                                fontWeight: '600',
                                                color: '#333'
                                            }}
                                        >
                                            {item.cart_qty}
                                        </span>

                                        <button
                                            disabled={loadingProductId === item.id}
                                            onClick={() => updateCartQty(item.id, 'plus')}
                                            style={{
                                                border: 'none',
                                                backgroundColor: '#f5f5f5',
                                                color: '#333',
                                                borderRadius: '50%',
                                                width: '28px',
                                                height: '28px',
                                                fontWeight: 'bold',
                                                fontSize: '16px',
                                                lineHeight: '1',
                                                display: 'flex',
                                                alignItems: 'center',
                                                justifyContent: 'center',
                                                cursor: 'pointer',
                                                marginLeft: '10px',
                                               
                                            }}
                                        >
                                        {loadingProductId === item.id ? (
                                            <span className="spinner-border spinner-border-sm text-secondary" />
                                        ) : (
                                            '+'
                                        )}
                                    </button>
                                    </div>

                            ) : (
                            <button
                                className="btn btn-sm w-100 mt-2 py-2 px-3 d-flex justify-content-center align-items-center rounded-pill"
                                style={{
                                    backgroundColor: '#1b1b1b',
                                    color: '#fff',
                                    fontWeight: 600,
                                    fontSize: '14px',
                                    border: 'none',
                                    transition: 'background 0.3s',
                                    minHeight: '38px'
                                }}
                                onClick={() => handleAddToCart(item.id)}
                                disabled={loadingProductId === item.id}
                            >
                                {loadingProductId === item.id ? (
                                    <span className="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                ) : (
                                    <i className="bi bi-cart3 me-2"></i>
                                )}
                                {loadingProductId === item.id ? 'Adding...' : 'Add to Cart'}
                            </button>
                                )}
                        </div>
                    </div>
                </div>
                </div>
    ))
}
        </div >
    );
}
