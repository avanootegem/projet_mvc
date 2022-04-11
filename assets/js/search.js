const searchBar = document.querySelector('#research');
const formSearchBar = document.querySelector('.research-bar');
const ul = document.getElementById('searchList');

let timeout = null;
let li = ``;

searchBar.addEventListener('input', () => {
    clearTimeout(timeout);
    let formData = new FormData(formSearchBar);
    fetch('search', {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => timeout = setTimeout(function () {data.forEach(element => {
            if (searchBar.value != '') {
                li += `
                    <a href="/projet_mvc/movie/${element.id_movie}"><li>${element.title}</li></a>
                `;
            } else {
                ul.innerHTML = '';
            }
        })
    ul.innerHTML = li;
    li = ``;
    }), 0);
})