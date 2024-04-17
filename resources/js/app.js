import './bootstrap';
import axios from "axios";

document.addEventListener('DOMContentLoaded', function () {
    setInterval(function () {
        // Про $.ajax знаю, но axios несколько удобнее в использовании.
        const response = axios.get('/api/events')
            .then(function (res) {
                var eventListItems = document.querySelector('#event_list ul');
                var data = res.data.result;

                if (data.length != eventListItems.children.length) {
                    eventListItems.innerHTML = '';
                    data.forEach(function (el, i) {
                        eventListItems.insertAdjacentHTML("beforeend",
                            '<li class="nav-item">' +
                            `<a class="nav-link ml-4 " href="http://localhost/event/${el.id}">` +
                            '<i class="far fa-fw fa-circle "></i>' +
                            `<p>${el.title}</p>` +
                            '</a></li>');
                    });
                }
            })
            .catch(err => console.error(err));
    }, 30000);
});
