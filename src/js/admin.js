import { $, all } from './DOMHelper.js';
import * as api from './api.js';

const paginationRegis = () => {
    const paginate_page = ["transaction", "user", "store"];

    const page = $('.page')?.getAttribute('id');
    const paginate_nav = all('.paginate_nav');

    if (paginate_page.includes(page) && paginate_nav.length > 0) {
        paginate_nav.forEach(el => {
            el.addEventListener('click', async (e) => {
                const list_input = all(`#${page} .search`);

                const class_list = Array.from(e.target.classList);
                const now_page = e.target.getAttribute('page');

                const selected_page = class_list.includes('prev') ? now_page - 1 : class_list.includes('next') ? Number(now_page) + 1 : now_page;


                let qs = Array.from(list_input).map((v) => `${page}[${v.getAttribute('id')}]=${v.value}`);
                qs = [...qs, `meta[page]=${selected_page}`].join("&");

                const result = await api.getList(page, qs, selected_page);
                if (result) {
                    $('.table tbody').innerHTML = result;
                } else {
                    $('.table tbody').innerHTML = `<tr>
                                                     <td colspan="6">Your search data not available, please use another keyword</td>
                                                   </tr>`
                }

                paginationRegis();
            });
        });
    }
}

(function () {
    paginationRegis();
})();

(async function () {
    const canvas = $('#user-growth');

    if (canvas) {
        const data_req = await api.getUsersGrowth();

        const labels = data_req.map(v => v.month).reverse();
        const dataset = data_req.map(v => v.value).reverse();
        const data = {
            labels: labels,
            datasets: [{
                label: 'user',
                data: dataset,
                backgroundColor: 'rgb(255, 205, 86)',
                borderColor: 'rgb(255, 205, 86)',
            }]
        };
        const config = {
            type: 'line',
            data: data,
        }
    
        new Chart(
            canvas, config
        );
    }
})();

(async function () {
    const canvas = $('#order-chart');

    if (canvas) {
        const data_req = await api.getOrderGrowth();
        const labels = data_req.map(v => v.month).reverse();
        const dataset = data_req.map(v => v.value).reverse();
        const data = {
            labels: labels,
            datasets: [{
                label: 'order',
                data: dataset,
                backgroundColor: 'rgb(54, 162, 235)',
                borderColor: 'rgb(54, 162, 235)',
                borderWidth: 1,
                barThickness: 25,
            }]
        };
        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        }

        new Chart(
            canvas, config
        );
    }
})();

(async function () {
    const canvas = $('#geo-chart');

    if (canvas) {
        const data_req = await api.getCountryOrder();
        const country_data = data_req.map(v => [v.country_code, v.total]);

        google.charts.load('current', {
            'packages': ['geochart'],
        });
            
        google.charts.setOnLoadCallback(() => {
            const data = google.visualization.arrayToDataTable([['Country', 'Ordered'], ...country_data]);
        
            var options = {
                colorAxis: {
                    colors: ['#fff', '#8FF83A']
                }
            };
        
            const chart = new google.visualization.GeoChart(canvas);
        
            chart.draw(data, options);
        });
    }
})();

(function () {
    const delete_btn = all('#store .delete-btn');

    delete_btn.forEach(el => {
        el.addEventListener("click", async (e) => {
            e.preventDefault();

            if (confirm('Are you sure delete this product ?')) {
                const product_id = e.target.getAttribute('product_id');
    
                const result = await api.removeProduct(product_id);
    
                if (result) {
                    $(`tr[product_id="${product_id}"]`).remove();
                }
            }
        });
    });
})();

(function () {
    const image = $('#image');
    const image_wrap = $('.image-wrap');
    const image_preview = $('.img-preview');

    if (image) {
        image.addEventListener("change", (e) => {
            var files = e.target.files || e.dataTransfer.files;
            var reader = new FileReader();

            reader.readAsDataURL(files[0]);
            reader.onload = (e) => {
                image_preview.setAttribute("src", e.target.result);
                image_wrap.classList.add("show");
            };
        });
    }
})();

(function () {
    const delete_btn = all('#user .delete-btn');

    delete_btn.forEach(el => {
        el.addEventListener("click", async (e) => {
            e.preventDefault();

            if (confirm('Are you sure delete this user ?')) {
                const user_id = e.target.getAttribute('user_id');

                const result = await api.removeUser(user_id);

                if (result) {
                    $(`tr[user_id="${user_id}"]`).remove();
                }
            }
        });
    });
})();

(function () {
    const search_page = ["transaction", "user", "store"];

    const page = $('.page')?.getAttribute('id');
    const input = all('.search');

    if (search_page.includes(page) && input.length > 0) {
        input.forEach(el => {
            el.addEventListener('change', async (e) => {
                const list_input = all(`#${page} .search`);
    
                let qs = Array.from(list_input).map((v) => `${page}[${v.getAttribute('id')}]=${v.value}`);
                qs = [...qs, `meta[page]=1`].join("&");

                const result = await api.getList(page, qs, 1);
                
                if (result) {
                    $('.table tbody').innerHTML = result;
                } else {
                    $('.table tbody').innerHTML = `<tr>
                                                     <td colspan="6">Your search data not available, please use another keyword</td>
                                                   </tr>`
                }
            });
        });
    }
})();