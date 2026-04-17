const registrobtn = document.getElementById('register');
const container = document.getElementById('container');
const loginbtn = document.getElementById('login');

registrobtn.addEventListener('click',()=>{
    container.classList.add('active');
});

loginbtn.addEventListener('click',()=>{
    container.classList.remove('active');
});
