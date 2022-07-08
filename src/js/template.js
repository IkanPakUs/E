// Methods

const formatPrice = (price) => {
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// HTML Element

const cart = (data) => {
    return `<div class="cart">
                <div class="cart__left-side">
                    <img src="src/img/product/${data.product.image_url}" alt="">
                </div>
                <div class="cart__right-side">
                    <div class="right-side__price">
                        <h6>Rp. ${formatPrice(data.product.price)} x ${data.quantity}</h6>
                        <h5>${data.product.name}</h5>
                    </div>
                    <div class="right_side__cart-remove">
                        <a class="btn-close remove-cart" product_id="${data.product_id}"></a>
                    </div>
                </div>
            </div>`
}

const catalog = (data) => {
    return `<div class="product">
                <div class="img-wrapper">
                    <img src="src/img/product/${data.image_url}" alt="catalog" loading="lazy">
                    <div class="wrapper__action">
                        <a class="wishlist">
                            <i class="bi wish-btn ${data.wishlist ? 'bi-heart-fill fill-btn' : 'bi-heart love-btn'}" product_id="${data.id}"></i>
                        </a>
                        <a class="add-cart">
                            <i class="bi cart-btn ${data.in_cart ? 'bi-cart-check-fill' : 'bi-cart-plus'}" product_id="${data.id}"></i>
                        </a>
                    </div >
                </div >
                <div class="info">
                    <div class="title">
                        <a href="#">${data.name}</a>
                    </div>
                    <div class="price">
                        <h6>Rp ${formatPrice(data.price)}</h6>
                    </div>
                </div>
            </div>`
}

const modal = (data) => {
    const list = data.length ? data.map((address) => addressList(address)).join(" ") : "";

    return `<div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Change Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="address-list-add">
                            <button type="button" class="btn add-address">Add new Address</button>
                        </div>
                        <div class="address-list">
                            ${list}
                        </div>
                    </div>
                </div>
            </div>`
}

const addressList = (address) => {

    let is_main = '';

    if (address.is_main == 0) {
        is_main = `<span></span> 
                    <a href="#" class="select-address" address_id="${address.id}">Select this address</a>`
    }

    return `<div class="address-card">
                <div class="address__info">
                    <div class="name-guest">
                        <span>${address.recipient}</span> (${address.title_address})
                    </div>
                    <div class="phone-no">
                        ${address.phone_no}
                    </div>
                    <div class="address">
                        <p>${[address.address, address.city, address.postal_code].join(', ')}</p>
                    </div>
                </div>
                <div class="address__action">
                    <a href="#" class="edit-address" address_id="${address.id}">Edit address</a>
                    ${is_main ?? ''}
                </div>
            </div>`
}

const addModal = (country) => {
    const template_option = country.map((v) => {
        return `<option value="${v.code}">${v.name}</option>`
    }).join(" ");

    return `<div class="modal-dialog add-address">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Address</h5>
                        <button type="button" class="btn-close form-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="address_id" id="address_id">
                        <div class="form-wrap">
                            <div class="column-group">
                                <div class="form-group form-label">
                                    <label for="label-address">Label Address</label>
                                    <input type="text" name="label" id="label-address">
                                </div>
                                <div class="form-group form-country">
                                    <label for="country">Country</label>
                                    <select name="country" id="country">
                                        ${template_option}
                                    </select>
                                </div>
                            </div>
                            <div class="column-group">
                                <div class="form-group form-recipient">
                                    <label for="recipient">Recipient</label>
                                    <input type="text" name="recipient" id="recipient">
                                </div>
                                <div class="form-group form-phone">
                                    <label for="phone">Phone</label>
                                    <input type="tel" name="phone" id="phone">
                                </div>
                            </div>
                            <div class="column-group">
                                <div class="form-group form-city">
                                    <label for="city">City</label>
                                    <input type="text" name="city" id="city">
                                </div>
                                <div class="form-group form-post">
                                    <label for="post-code">Postal Code</label>
                                    <input type="text" name="post-code" id="post-code">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn form-close">Close</button>
                        <button type="button" class="btn save-address">Save changes</button>
                    </div>
                </div>
            </div>`
}

const transaction = (data, i) => {
        return `<tr transaction_id="${data.id}">
                    <td class="serial">${++i}</td>
                    <td><span class="name">${data.code}</span></td>
                    <td><span class="count">${data.user_name}</span></td>
                    <td><span class="transaction">${formatPrice(data.grand_total)}</span></td>
                    <td><span class="count ${data.status_name}">${data.status_name}</span></td>
                    <td><span class="count">${data.created_at}</span></td>
                    <td>
                        <a href="detail-transaction.php?id=${data.id}">Show</a>
                    </td>
                </tr>`
}

const user = (data, i) => {
    return `<tr user_id="${data.id}">
                <td>${++i}</td>
                <td>${data.name}</td>
                <td>${data.email}</td>
                <td>${data.role_name}</td>
                <td>
                    <a href="form-user.php?id=${data.id}">Edit</a>
                    /
                    <a href="#" class="delete-btn" user_id="${data.id}">Delete</a>
                </td>
            </tr>`
}

const store = (data, i) => {
    return `<tr product_id="${data.id}">
                <td class="serial">${++i}</td>
                <td><span class="name">${data.name}</span></td>
                <td><span class="product">${formatPrice(data.price)}</span></td>
                <td><span class="count">${data.category_name}</span></td>
                <td>
                    <a href="form-product.php?id=${data.id}">Edit</a>
                    /
                    <a href="#" class="delete-btn" product_id="${data.id}">Delete</a>
                </td>
            </tr>`
}

const pagination = (i) => {
    ++i
    return `<li page="${i}" class="paginate_nav">${i}</li>`
}

export { catalog, cart, modal, addModal, transaction, user, store, pagination }