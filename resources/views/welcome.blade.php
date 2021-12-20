<!doctype html>
<html lang="en">

<head>
    <title>VENTAS</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        .scrolling-wrapper {
            height: 70vh;
            overflow-y: scroll;
        }
    </style>
</head>

<body>


    <div class="container-fluid mt-4">

        <div class="row" id="container">
            <div class="col">

                <p class="h2">Ventas</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5">


                <div class="card scrolling-wrapper">

                    <!-- datos descriptivos -->
                    <div class="col d-none">
                        <h3 class="h5 text-center text-uppercase">Datos Descriptivos</h3>
                        <div class="form-group row mx-3">
                            <div class="row justify-content-center">
                                <input type="hidden" id="id_producto">
                                <div class="col-md-5">
                                    Precio
                                    <input type="text" class="form-control" placeholder="Precio Venta" disabled id="preciog">

                                </div>
                                <div class="col-md-5">
                                    Existencia
                                    <input type="text" class="form-control" placeholder="Existencia" disabled id="existenciag">
                                </div>

                                <div class="col-md-5">
                                    Cantidad
                                    <input type="number" class="form-control" value="1" id="cantidadg">
                                </div>
                                <div class="col-md-5">
                                    Descuento
                                    <input type="number" class="form-control" placeholder="Descuento" id="descuentog">
                                </div>
                            </div>

                            <button type="button" onclick="addToTable()" class="btn btn-primary btn-sm btn-block mt-2">ADD</button>

                        </div>
                    </div>
                    <!-- end datos descriptivos -->



                    <div class="table-hover p-2">
                        <table class="table table-hover table-sm " id="tabla_venta">
                            <thead class="" style="    background-color: #1eb3a2;color: white;">
                                <tr>
                                    <th></th>
                                    <th>ARTICULO</th>
                                    <th>P. VENTA</th>
                                    <th>DES.</th>
                                    <th>CANT</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>

                                </tr>

                            </tbody>
                        </table>


                        <label id="total"> </label>
                    </div>

                </div>
            </div>

            <div class="col-md-7">

                <div class="form-group">
                    <label for="">ARTICULO</label>
                    <input type="text" id="producto" class="form-control" placeholder="PRODUCTO A BUSCAR">
                </div>

                <div class="row scrolling-wrapper overflow-auto" id="result">

                </div>



            </div>
        </div>
    </div>




    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


    <script>
        var total = 0;
        var cont = 0;
        var subtotal = Array;

        const formulario = document.querySelector('#producto')
        const result = document.querySelector('#result')
        const preciog = document.querySelector('#preciog')
        const existenciag = document.querySelector('#existenciag')
        const cantidadg = document.querySelector('#cantidadg')
        const descuentog = document.querySelector('#descuentog')
        const id_producto = document.querySelector('#id_producto')
        const container = document.querySelector('#container')
        const totalg = document.querySelector('#total')
        const tabla_venta = $('#tabla_venta')
        var nombreg = '';
        var descripciong = '';

        cantidadg.value = 1;

        const product = [

            <?php foreach ($data as $pro) { ?> {
                    id: <?php echo $pro->id; ?>,
                    nombre: '<?php echo $pro->name; ?>',
                    codigo: '<?php echo $pro->code; ?>',
                    precio: <?php echo $pro->p_venta; ?>,
                    descripcion: '<?php echo $pro->des; ?>',
                    img: '<?php echo $pro->img; ?>'
                },
            <?php } ?>
        ]

        const filtrar = () => {

            result.innerHTML = '';
            const texto = formulario.value.toLowerCase();

            for (let data of product) {
                let nombre = data.nombre.toLowerCase();
                let desc = data.descripcion.toLowerCase();
                let code = data.codigo.toLowerCase();
                if (nombre.indexOf(texto) !== -1 || desc.indexOf(texto) !== -1 || code.indexOf(texto) !== -1) {

                    result.innerHTML += `
               <div class="col-md-3 cursot-pointer mt-2" onclick="add(${data.id})">
               <div class="card">
                    <img class="card-img-top" src="${data.img}" alt="">
                    <div class="card-body">
                        <h4 class="card-title">${data.nombre}</h4>
                        <p class="card-text">${data.descripcion}</p>
                        <p class="card-text">Q. ${data.precio / 1}</p>
                    </div>
                </div>
               </div>
                    `
                }
            }

            if (result.innerHTML === '') {
                result.innerHTML = '<li>Producto no Encontrado</li>';
            }

        }


        filtrar();
        formulario.addEventListener('keyup', filtrar)



        function add(idpro) {
            const {
                id,
                nombre,
                codigo,
                precio,
                descripcion
            } = product.find(e => e.id === idpro);

            preciog.value = precio
            // cambiar la existencia por la del producto
            existenciag.value = 1000
            id_producto.value = id
            nombreg = nombre;
            descripciong = descripcion;
            addToTable();
        }

        function limpiar() {

        }


        function addToTable() {

            var newdescuento = 0;

            if (descuentog.value > 0) {
                newdescuento = (descuentog.value) * cantidadg.value;
            }

            if (id_producto.value != '' && preciog.value != '' && cantidadg.value != '' && existenciag.value != '') {

                subtotal[cont] = (cantidadg.value * preciog.value) - newdescuento;
                total = total + subtotal[cont];

                var fila = '<tr class="selected" id="fila' + cont + '">' +
                    '<td><a href="#" class="btn btn-danger btn-sm" onclick="eliminar_fila(' + cont + ')">X</a></td>' +
                    '<td><input type="hidden" name="articulo_id[]" value="' + id_producto.value + '">' + nombreg + descripciong + '</td>' +
                    '<td><input type="number" class="form-control"  name="precioventa[]" value="' + preciog.value + '" readonly></td> ' +
                    '<td><input type="number" class="form-control"  name="descuento[]" value="' + newdescuento + '" readonly ></td> ' +
                    '<td><input type="number" class="form-control"  name="cantidad[]" value="' + cantidadg.value + '" readonly ></td> ' +
                    '<td> <input type="hidden" name="subtotal[]" value="' + subtotal[cont] + '">' + subtotal[cont] + '</td>' +
                    '</tr>';
                cont++;

                limpiar();

                tabla_venta.append(fila);

                totalg.innerHTML = ' <input type="number" id="totvent" name="totalventa" class="form-control" value="' + total + '" readonly > '
                console.log(total);


            } else {

                container.innerHTML += `
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <strong>SELECCIONE!</strong> UN PRODUCTO.
                </div>
            `

            }

        }
    </script>


    <script>
        function agregar() {

            // console.log(pventa);
            // console.log(cantidad);

            if (idmedicamento != "" && pventa != "" && existenci != "" && cantidad != "") {
                if (cantidad <= existenci) {

                    subtotal[cont] = (cantidad * pventa) - newdescuento;
                    total = total + subtotal[cont];




                    total_venta.html('<input type="number" id="totvent" name="totalventa" class="form-control" value="' + total + '" readonly >');
                    tabla.append(fila);
                } else {
                    alert('LA CANTIDAD A VENDER SUERA LA EXISTENCIA');
                }

            } else {
                alert('TODOS LOS CAMPOS DEBEN DE ESTAR LLENOS');
            }
        }

        function eliminar_fila(index) {
            total = total - subtotal[index];

            total_venta.innerHTML('<input type="number" name="totalventa" class="form-control" value="' + total + '" readonly >');
            $('#fila' + index).remove();
        }

        function cambiofun() {

            var totVent = $('#totvent').val();

            var cambio = parseFloat(efectivo.val()) - parseFloat(totVent);

            console.log(cambio);

            $('#cambio').val(cambio);


        }


        function nuevototal() {

            let total = parseFloat($('#totvent').val());

            let descuento = parseFloat($('#descuento_mayorista').val());

            if (descuento > 0) {

                let newdescuento = (total * descuento) / 100;

                let newTotalDec = total - newdescuento;

                $('#totvent').val(newTotalDec);



            } else {
                return;
            }
        }
    </script>



</body>

</html>