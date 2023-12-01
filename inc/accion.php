<script>
        // Asigna funciones a los botones cuando el documento esté listo
        document.addEventListener("DOMContentLoaded", function() {
            // Obtén una referencia a los botones
            var btnEntrada = document.getElementById("btnEntrada");
            var btnSalida = document.getElementById("btnSalida");

            // Agrega funciones de clic a los botones
            btnEntrada.addEventListener("click", function() {
                // Lógica para el botón de Entrada
                alert("Realizar acciones para la entrada");
                // Puedes redirigir a otra página o realizar otras acciones según tu lógica
            });

            btnSalida.addEventListener("click", function() {
                // Lógica para el botón de Salida
                alert("Realizar acciones para la salida");
                // Puedes redirigir a otra página o realizar otras acciones según tu lógica
            });
        });
    </script>