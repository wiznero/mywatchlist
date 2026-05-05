document.addEventListener('DOMContentLoaded', () => {
    //JS para el login y registro
    const registrobtn = document.getElementById('register');
    const container = document.getElementById('container');
    const loginbtn = document.getElementById('login');

    registrobtn.addEventListener('click',()=>{
        container.classList.add('active');
    });

    loginbtn.addEventListener('click',()=>{
        container.classList.remove('active');
    });

    //JS para mostrar contraseña login
    const icono = document.getElementById('toggle-password');
    const input = document.getElementById('password');

    icono.addEventListener('click', () => {
        if (input.type === 'password') {
            input.type = 'text';
            icono.name = 'eye-outline';
        } else {
            input.type = 'password';
            icono.name = 'eye-off-outline';

        }
    })

    //JS para mostrar contraseña registro
    const icono_registro = document.getElementById('toggle-password-registro');
    const input_registro = document.getElementById('password-registro');

    icono_registro.addEventListener('click', () => {
        if (input_registro.type === 'password') {
            input_registro.type = 'text';
            icono_registro.name = 'eye-outline';
        } else {
            input_registro.type = 'password';
            icono_registro.name = 'eye-off-outline';

        }
    })
});
