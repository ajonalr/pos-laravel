


const formulario = document.querySelector('#producto')
const boton = document.querySelector('#boton')

const filtrar = () => {

   console.log(formulario.value);

}


boton.addEventListener('click', filtrar)