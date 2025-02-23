<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Vales</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #1e293b;
            color: #ffffff;
            min-height: 100vh;
        }

        .container {
            max-width: 480px;
            margin: 0 auto;
            min-height: 100vh;
            backdrop-filter: blur(10px);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #ffffff;
            font-size: 2.5em;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .create-button {
            background-color: #34d399;
            color: #1e293b;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .create-button:hover {
            background-color: #3ee6a8;
            transform: translateY(-2px);
        }

        .form-container {
            background-color: #2a3b53;
            padding: 25px;
            border-radius: 12px;
            border: 2px solid #34d399;
            margin-bottom: 30px;
            display: none;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #ffffff;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 2px solid #34d399;
            border-radius: 6px;
            background-color: #1e293b;
            color: #ffffff;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #3ee6a8;
            box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.2);
        }

        button {
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 10px 20px;
        }

        .edit-button {
            background-color: #34d399;
            color: #1e293b;
            font-size: 0.9em;
        }

        .edit-button:hover {
            background-color: #3ee6a8;
            transform: translateY(-1px);
        }

        button[type="submit"] {
            background-color: #34d399;
            color: #1e293b;
            width: 100%;
            padding: 12px;
            font-size: 1.1em;
        }

        button[type="submit"]:hover {
            background-color: #3ee6a8;
        }

        .table-container {
            background-color: #2a3b53;
            border-radius: 12px;
            border: 2px solid #34d399;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #34d399;
        }

        th {
            background-color: #34d399;
            color: #1e293b;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        tr:hover {
            background-color: #243447;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .precio {
            font-family: monospace;
            font-size: 1.1em;
            color: #34d399;
        }

        .error {
            color: #ef4444;
            font-size: 0.9em;
            margin-top: 5px;
        }

        /* Estilos para el modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            backdrop-filter: blur(4px);
        }

        .modal-content {
            position: relative;
            background-color: #2a3b53;
            margin: 10% auto;
            padding: 30px;
            border: 2px solid #34d399;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            animation: modalSlideDown 0.3s ease-out;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal h2 {
            color: #34d399;
            margin-bottom: 20px;
            font-size: 1.8em;
        }

        @keyframes modalSlideDown {
            from {
                transform: translateY(-100px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-buttons {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-top: 30px;
        }

        .modal-buttons button {
            flex: 1;
            padding: 12px;
            font-size: 1em;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .save-button {
            background-color: #34d399;
            color: #1e293b;
        }

        .save-button:hover {
            background-color: #3ee6a8;
            transform: translateY(-2px);
        }

        .cancel-button {
            background-color: #475569;
            color: #ffffff;
        }

        .cancel-button:hover {
            background-color: #64748b;
            transform: translateY(-2px);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .new-row {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Gestión de Vales</h1>

    <div class="button-container">
        <button class="create-button" id="showForm">Crear Vale</button>
    </div>

    <!-- Formulario para crear comidas -->
    <div class="form-container" id="formContainer">
        <form id="comidaForm">
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <input type="text" id="descripcion" name="descripcion" required>
            </div>

            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" step="0.01" required>
            </div>

            <button type="submit">Guardar Vale</button>
        </form>
    </div>

    <!-- Modal de edición -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <h2>Editar Vale</h2>
            <form id="editForm">
                <input type="hidden" id="editId">
                <div class="form-group">
                    <label for="editDescripcion">Descripción:</label>
                    <input type="text" id="editDescripcion" name="descripcion" required>
                </div>

                <div class="form-group">
                    <label for="editPrecio">Precio:</label>
                    <input type="number" id="editPrecio" name="precio" step="0.01" required>
                </div>

                <div class="modal-buttons">
                    <button type="submit" class="save-button">Guardar</button>
                    <button type="button" class="cancel-button" onclick="closeModal()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de comidas -->
    <div class="table-container">
        <table id="comidasTable">
            <thead>
            <tr>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <!-- Las comidas se cargarán aquí dinámicamente -->
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Toggle del formulario
        $('#showForm').click(function() {
            $('#formContainer').slideToggle(300);
            $(this).text(function(i, text) {
                return text === "Crear Vale" ? "Cerrar Formulario" : "Crear Vale";
            });
        });

        // Cargar comidas existentes
        cargarComidas();

        // Manejar el envío del formulario de creación
        $('#comidaForm').on('submit', function(e) {
            e.preventDefault();

            const descripcion = $('#descripcion').val();
            const precio = $('#precio').val();

            $.ajax({
                url: '/crearVale',
                method: 'POST',
                data: {
                    descripcion: descripcion,
                    precio: precio,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#comidaForm')[0].reset();
                    $('#formContainer').slideUp(300);
                    $('#showForm').text('Crear Vale');
                    cargarComidas();
                },
                error: function(xhr) {
                    alert('Error al guardar el vale');
                }
            });
        });

        // Manejar el envío del formulario de edición
        $('#editForm').on('submit', function(e) {
            e.preventDefault();

            const id = $('#editId').val();
            const descripcion = $('#editDescripcion').val();
            const precio = $('#editPrecio').val();

            $.ajax({
                url: '/editarVale',
                method: 'POST',
                data: {
                    id: id,
                    descripcion: descripcion,
                    precio: precio,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    closeModal();
                    cargarComidas();
                },
                error: function(xhr) {
                    alert('Error al editar el vale');
                }
            });
        });

        function cargarComidas() {
            $.ajax({
                url: '/getVales',
                method: 'GET',
                success: function(comidas) {
                    const tbody = $('#comidasTable tbody');
                    tbody.empty();

                    comidas.forEach(function(comida) {
                        const row = $(`
                                <tr class="new-row">
                                    <td>${comida.descripcion}</td>
                                    <td class="precio">${comida.precio ? '$' + comida.precio.toFixed(2) : '-'}</td>
                                    <td>
                                        <button class="edit-button" onclick="editarVale(${comida.id}, '${comida.descripcion}', ${comida.precio})">
                                            Editar
                                        </button>
                                    </td>
                                </tr>
                            `);
                        tbody.append(row);
                    });
                },
                error: function(xhr) {
                    alert('Error al cargar los vales');
                }
            });
        }
    });

    // Funciones para el modal
    function editarVale(id, descripcion, precio) {
        $('#editId').val(id);
        $('#editDescripcion').val(descripcion);
        $('#editPrecio').val(precio);
        $('#editModal').show();
    }

    function closeModal() {
        $('#editModal').hide();
        $('#editForm')[0].reset();
    }

    // Cerrar modal al hacer clic fuera de él
    window.onclick = function(event) {
        const modal = document.getElementById('editModal');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>
</body>
</html>
