import { $, all } from './DOMHelper.js';
import * as template from './template.js';

const productFilter = (qs) => {
    return new Promise(resolve => {
        fetch(`helpers/Search.php?${qs}`, {
            method: "GET",
            headers: {
                'Content-type': 'application/json'
            }
        }).then(async (res) => {
            const result = await res.json().then(result => result);
    
            if (['name', 'category'].includes(result.filter.type)) {
                localStorage.setItem(result.filter.type, result.filter.value);
            }
    
            if (result.status) {
                const data = JSON.parse(result.data)
                const total = data.length;
                const el = data.map((v) => template.catalog(v)).join(" ");

                const products = {
                    el,
                    total,
                }
                
                return resolve(products)
            }

            return resolve(false);
        });
    });
}

const wishlistAction = (product_id) => {
    return new Promise((resolve) => {
        fetch(`helpers/CartDomain.php?id=${product_id}&method=wishlist`, {
            method: 'GET',
        }).then(async (res) => {
            const result = await res.json().then(result => result);

            if ('code' in result) {
                result.code == 401 ? document.location = 'login.php' : '';
            }
            
            return resolve(result);
        }).catch(err => console.log(err));
    });
}

const addCart = (product_id) => {
    return new Promise(resolve => {
        fetch(`helpers/CartDomain.php?id=${product_id}&method=addCart`, {
            method: 'GET',
        }).then(async (res) => {
            const result = await res.json().then(result => result);
            
            if ('code' in result) {
                result.code == 401 ? document.location = 'login.php' : '';
            }

            if (result.data) {
                if (result.data != false) {
                    const el = result.data.map((v) => template.cart(v)).join(" ");
                    return resolve(el);
                }
            }
            
            return resolve(false);

        }).catch(err => console.log(err))
    });
}

const removeCart = (product_id) => {
    return new Promise(resolve => {
        fetch(`helpers/CartDomain.php?id=${product_id}&method=removeCart`, {
            method: 'GET',
        }).then(async (res) => {
            const result = await res.json().then(result => result);

            if (result.data != false) {
                const el = result.data.map((v) => template.cart(v)).join(" ");
                return resolve(el);
            }
            return resolve(false);

        }).catch(err => console.log(err))
    });
}

const removeProduct = (product_id) => {
    return new Promise(resolve => {
        fetch(`../helpers/StoreDomain.php`, {
            method: 'POST',
            body: JSON.stringify({'method': 'delete', 'id': product_id}),
        }).then(async () => {
            return resolve(true);
        }).catch(err => console.log(err));
    });
}

const removeUser = (user_id) => {
    return new Promise(resolve => {
        fetch(`../helpers/UserDomain.php`, {
            method: 'POST',
            body: JSON.stringify({'method': 'delete', 'id': user_id}),
        }).then(() => {
            return resolve(true);
        }).catch(err => console.log(err))
    });
}

const selectAddress = (address_id) => {
    return new Promise(resolve => {
        fetch(`helpers/AddressDomain.php?id=${address_id}&method=selectAddress`, {
            method: 'GET',
        }).then(() => {
            return resolve(true);
        }).catch(err => console.log(err));
    });
}

const getCountry = () => {
    return new Promise(resolve => {
        fetch(`helpers/AddressDomain.php`, {
            method: 'POST',
            body: JSON.stringify({
                'method': 'getCountry',
            }),
        }).then(async (res) => {
            const result = await res.json().then(result => result);

            if (result.status) {
                const el = template.addModal(result.country);
                return resolve(el);
            }
            return resolve(false);

        }).catch(err => console.log(err));
    }); 
}

const saveAddress = (data) => {
    return new Promise(resolve => {
        fetch(`helpers/AddressDomain.php`, {
            method: 'POST',
            body: JSON.stringify({
                'method': 'saveAddress',
                'payload': JSON.stringify(data)
            }),
        }).then(async (res) => {
            const result = await res.json().then(result => result);

            if (result.status) {
                const el = template.modal(result.data);
                return resolve(el);
            }
            return resolve(false);

        }).catch(err => console.log(err));
    }); 
}

const getAddress = () => {
    return new Promise(resolve => {
        fetch(`helpers/AddressDomain.php?method=getAddress`, {
            method: 'GET'
        }).then(async (res) => {
            const result = await res.json().then(result => result);

            if (result.status) {    
                const el = template.modal(result.data);
                return resolve(el);
            }
            return resolve(false);

        }).catch(err => console.log(err));
    });
}

const editAddress = (address_id) => {
    return new Promise(resolve => {
        fetch(`helpers/AddressDomain.php?method=editAddress&id=${address_id}`, {
            method: 'GET',
        }).then(async (res) => {
            const result = await res.json().then(result => result);

            if (result.status) {
                return resolve(result.data);
            }
            return resolve(false);
        }).catch(err => console.log(err));
    });
}

const getUsersGrowth = () => {
    return new Promise(resolve => {
        fetch(`../helpers/AnalyticDomain.php`, {
            method: 'POST',
            body: JSON.stringify({ 'method': 'getUsersGrowth'}),
        }).then(async (res) => {
            const result = await res.json().then(result => result);

            if (result.status) {
                return resolve(result.data);
            }
            return resolve(false);
        }).catch(err => console.log(err));
    });
}

const getOrderGrowth = () => {
    return new Promise(resolve => {
        fetch(`../helpers/AnalyticDomain.php`, {
            method: 'POST',
            body: JSON.stringify({ 'method': 'getOrderGrowth'}),
        }).then(async (res) => {
            const result = await res.json().then(result => result);

            if (result.status) {
                return resolve(result.data);
            }
            return resolve(false);
        }).catch(err => console.log(err));
    });
}

const getCountryOrder = () => {
    return new Promise(resolve => {
        fetch(`../helpers/AnalyticDomain.php`, {
            method: 'POST',
            body: JSON.stringify({ 'method': 'getCountryOrder'}),
        }).then(async (res) => {
            const result = await res.json().then(result => result);

            if (result.status) {
                return resolve(result.data);
            }
            return resolve(false);
        }).catch(err => console.log(err));
    });
}

const getList = (page, qs) => {
    return new Promise(resolve => {
        fetch(`../helpers/Search.php?${qs}&page=${page}`)
        .then(async (res) => {
            const result = await res.json().then(result => result);

            if (result.status && result.data) {
                const el = result.data.map((v, i) => template[page](v, i)).join(" ");

                $('.pagination__page-info ul').innerHTML = "i".repeat(result.meta.total).split('').map((v, i) => {
                    return template.pagination(i);
                }).join(" ");

                all(`#${page} li.paginate_nav`).forEach(el => {
                    el.classList.remove('active');
                });
                $(`#${page} li.paginate_nav[page="${result.meta.page}"]`).classList.add('active');

                all(`#${page} i.paginate_nav`).forEach(el => {
                    el.setAttribute('page', result.meta.page);
                });

                result.meta.page >= result.meta.total ? $(`#${page} i.paginate_nav.next`).classList.add('disable') : $(`#${page} i.paginate_nav.next`).classList.remove('disable');
                result.meta.page > 1 ? $(`#${page} i.paginate_nav.prev`).classList.remove('disable') : $(`#${page} i.paginate_nav.prev`).classList.add('disable');

                return resolve(el);
            }

            return resolve(false);
        }).catch(err => console.log(err));
    });
}

export {productFilter, wishlistAction, addCart, removeCart, removeProduct, removeUser, selectAddress, getCountry, saveAddress, getAddress, editAddress, getUsersGrowth, getOrderGrowth, getCountryOrder, getList};