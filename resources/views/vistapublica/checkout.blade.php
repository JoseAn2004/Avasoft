<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Checkout Avasoft</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Red Hat Display', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 pb-32">
    <header class="bg-orange-500 shadow-md p-4">
        <div class="container mx-auto flex items-center space-x-4">
            <img src="{{ asset('images/logong.png') }}" alt="Logo" class="h-14 ml-4 w-38">
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 pt-6 pb-32">
        <button onclick="window.location.href='/'" class="flex items-center text-sm text-gray-600 hover:text-gray-800 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Volver al inicio
        </button>

        <h1 class="text-2xl font-bold mb-6 text-left border-b border-gray-300 pb-2">Finaliza tu compra</h1>

        <div class="flex flex-col lg:flex-row items-start gap-6">
            <section class="flex-[2] space-y-6 w-full">
                <div class="bg-white rounded-lg shadow-md p-6 relative group">
                    <button onclick="toggleEdit('titular')" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800">✎</button>
                    <h2 class="text-lg font-semibold mb-4">Datos del titular</h2>
                    <div id="titularDisplay" class="space-y-2">
                        <p><strong>Nombres completos:</strong> <span id="viewTitularNombre">{{ Auth::user()->name }}</span></p>
                        <p><strong>DNI:</strong> <span id="viewTitularDNI">{{ Auth::user()->perfil->dni ?? 'Sin información' }}</span></p>
                        <p><strong>Teléfono:</strong> <span id="viewTitularTelefono">{{ Auth::user()->perfil->telefono ?? 'Sin información' }}</span></p>
                        <p><strong>Correo:</strong> <span id="viewTitularCorreo">{{ Auth::user()->email }}</span></p>

                    </div>
                    <div id="titularEdit" class="grid grid-cols-1 md:grid-cols-2 gap-4 hidden">
                        <input id="titularNombre" type="text" value="{{ Auth::user()->name }}" placeholder="Nombre completo" class="border border-gray-300 rounded-md px-4 py-2">
                        <input id="titularDNI" type="number" value="{{ Auth::user()->perfil->dni ?? '' }}" placeholder="DNI" class="border border-gray-300 rounded-md px-4 py-2">
                        <input id="titularTelefono" type="text" value="{{ Auth::user()->perfil->telefono ?? '' }}" placeholder="Teléfono" class="border border-gray-300 rounded-md px-4 py-2">

                        <input id="titularCorreo" type="email" value="{{ Auth::user()->email }}" placeholder="Correo electrónico" class="border border-gray-300 rounded-md px-4 py-2 md:col-span-2">
                    </div>
                </div>




                <div class="bg-white rounded-lg shadow-md p-6 relative group">
                    <h2 class="text-lg font-semibold mb-2">Método de entrega</h2>
                    <p class="text-sm text-gray-600 mb-4">Completa los campos según el tipo de envío.</p>

                    <select id="entregaTipo" onchange="mostrarCampos()"
                        class="border border-gray-300 rounded-md px-4 py-2 w-full mb-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">Selecciona el tipo de envío</option>
                        <option value="delivery">Delivery</option>
                        <option value="recojo">Recojo en tienda</option>
                        <option value="provincia">Envío a provincia</option>
                    </select>

                    <span id="infoDelivery" class="text-xs text-gray-400 hidden">* Solo disponible para distritos cercanos a Chincha Alta</span>

                    <!-- Delivery -->
                    <div id="formDelivery" class="hidden mt-6 border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <h3 class="text-base font-medium text-gray-800 mb-4">Datos para delivery</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="text-sm text-gray-600 block mb-1">Dirección</label>
                                <input id="direccion" type="text" placeholder="Ej. Av. Los Ángeles"
                                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    oninput="mostrarResumen()">
                            </div>
                            <div>
                                <label class="text-sm text-gray-600 block mb-1">Número</label>
                                <input id="numero" type="text" placeholder="Ej. 123"
                                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    oninput="mostrarResumen()">
                            </div>
                            <div>
                                <label class="text-sm text-gray-600 block mb-1">Referencia</label>
                                <input id="referencia" type="text" placeholder="Ej. Frente a la plaza"
                                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    oninput="mostrarResumen()">
                            </div>
                            <div>
                                <label class="text-sm text-gray-600 block mb-1">Distrito</label>
                                <select id="distrito" onchange="mostrarResumen()"
                                    class="w-full border border-gray-300 rounded px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                                    <option value="">Selecciona distrito</option>
                                    <option value="Chincha Alta">Chincha Alta</option>
                                    <option value="Sunampe">Sunampe</option>
                                    <option value="Grocio Prado">Grocio Prado</option>
                                    <option value="Pueblo Nuevo">Pueblo Nuevo</option>
                                    <option value="Alto Larán">Alto Larán</option>
                                    <option value="Chincha Baja">Chincha Baja</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Recojo en tienda -->
                    <div id="formRecojo" class="hidden mt-6 border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <h3 class="text-base font-medium text-gray-800 mb-4">Datos para recojo en tienda</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="text-sm text-gray-600 block mb-1">Fecha de recojo</label>
                                <input id="fechaRecojo" type="date"
                                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    onchange="mostrarResumen()">
                            </div>
                            <div>
                                <label class="text-sm text-gray-600 block mb-1">Hora de recojo</label>
                                <input id="horaRecojo" type="time"
                                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    onchange="mostrarResumen()">
                            </div>
                            <div>
                                <label class="text-sm text-gray-600 block mb-1">Sede</label>
                                <select id="sedeTienda"
                                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    onchange="mostrarResumen()">
                                    <option value="">Selecciona una tienda Avalanch</option>
                                    <option value="Tienda Avalanch Chincha">Tienda Avalanch Chincha</option>
                                    <option value="Tienda Avalanch Pisco">Tienda Avalanch Pisco</option>
                                    <option value="Tienda Avalanch Ayacucho III">Tienda Avalanch Ayacucho III</option>
                                    <option value="Tienda Avalanch Villa El Salvador">Tienda Avalanch Villa El Salvador</option>
                                    <option value="Tienda Avalanch Pro">Tienda Avalanch Pro - Los Olivos</option>
                                    <option value="Tienda Avalanch Carabayllo">Tienda Avalanch Carabayllo</option>
                                    <option value="Tienda Avalanch Comas 4">Tienda Avalanch Comas 4</option>
                                    <option value="Tienda Avalanch Ventanilla">Tienda Avalanch Ventanilla</option>
                                    <option value="Tienda Avalanch Pachacutec">Tienda Avalanch Pachacutec</option>
                                    <option value="Tienda Avalanch Huacho">Tienda Avalanch Huacho</option>
                                    <option value="Tienda Avalanch Barranca">Tienda Avalanch Barranca</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Provincia -->
                    <div id="formProvincia" class="hidden mt-6 border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <h3 class="text-base font-medium text-gray-800 mb-4">Datos para envío a provincia</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="flex flex-col">
                                <label class="text-sm text-gray-600 mb-1">Empresa de envío</label>
                                <select id="empresaEnvio"
                                    class="border border-gray-300 rounded px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    onchange="mostrarResumen()">
                                    <option value="">Seleccione</option>
                                    <option value="Olva Courier">Olva Courier</option>
                                </select>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-sm text-gray-600 mb-1">Departamento</label>
                                <select id="departamento" onchange="cargarProvincias(); mostrarResumen()"
                                    class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-sm text-gray-600 mb-1">Provincia</label>
                                <select id="provincia" onchange="cargarDistritos(); mostrarResumen()"
                                    class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-sm text-gray-600 mb-1">Distrito</label>
                                <select id="distritoProv" onchange="mostrarResumen()"
                                    class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="botonGuardarWrapper" class="hidden mt-4">
                        <button onclick="guardarDatos()" class="flex justify-between items-center bg-orange-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition w-full">
                            <span class="text-sm font-medium">Guardar datos</span>
                            <!-- Icono Guardar (Disk) -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                            </svg>
                        </button>
                    </div>

                    <div id="botonEditarWrapper" class="hidden mt-4">
                        <button onclick="editarDatos()" class="flex justify-between items-center bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition w-full">
                            <span class="text-sm font-medium">Editar datos</span>
                            <!-- Icono Editar (Pencil) -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4h10M11 12h10M7 20h10M4 6h.01M4 14h.01M4 22h.01" />
                            </svg>
                        </button>
                    </div>


                    <!-- Resumen -->
                    <!-- Resumen -->
                    <div id="resumen" class="hidden mt-6 border border-orange-300 bg-orange-50 rounded-lg p-4 text-sm text-gray-800 shadow-sm">
                        <h3 class="text-base font-semibold text-orange-700 mb-2">Resumen del pedido</h3>
                        <div id="contenidoResumen" class="space-y-2 text-sm"></div>
                    </div>
                </div>

                <script>
                    let departamentos = [],
                        provincias = [],
                        distritos = [];

                    window.addEventListener("DOMContentLoaded", async () => {
                        try {
                            const [depsRes, provsRes, distsRes] = await Promise.all([
                                fetch("/json/ubigeo_peru_departamentos.json"),
                                fetch("/json/ubigeo_peru_provincias.json"),
                                fetch("/json/ubigeo_peru_distritos.json")
                            ]);

                            departamentos = await depsRes.json();
                            provincias = await provsRes.json();
                            distritos = await distsRes.json();

                            const depSelect = document.getElementById("departamento");
                            departamentos.forEach(dep => {
                                const opt = document.createElement("option");
                                opt.value = dep.id;
                                opt.textContent = dep.name;
                                depSelect.appendChild(opt);
                            });
                        } catch (error) {
                            console.error("Error cargando datos de ubicación:", error);
                        }
                    });

                    function mostrarCampos() {
                        const tipo = document.getElementById("entregaTipo").value;
                        ["formDelivery", "formRecojo", "formProvincia"].forEach(id => {
                            document.getElementById(id).classList.add("hidden");
                        });
                        if (tipo === "delivery") {
                            document.getElementById("formDelivery").classList.remove("hidden");
                        } else if (tipo === "recojo") {
                            document.getElementById("formRecojo").classList.remove("hidden");
                        } else if (tipo === "provincia") {
                            document.getElementById("formProvincia").classList.remove("hidden");
                        }

                        document.getElementById("infoDelivery").classList.toggle("hidden", tipo !== "delivery");
                        document.getElementById("botonGuardarWrapper").classList.remove("hidden");
                        document.getElementById("botonEditarWrapper").classList.add("hidden");
                        document.getElementById("resumen").classList.remove("hidden");

                        mostrarResumen();
                    }

                    function cargarProvincias() {
                        const dptoId = document.getElementById("departamento").value;
                        const provinciaSelect = document.getElementById("provincia");
                        const distritoSelect = document.getElementById("distritoProv");

                        provinciaSelect.innerHTML = "<option value=''>Provincia</option>";
                        distritoSelect.innerHTML = "<option value=''>Distrito</option>";

                        provincias.filter(p => p.department_id === dptoId).forEach(p => {
                            const opt = document.createElement("option");
                            opt.value = p.id;
                            opt.textContent = p.name;
                            provinciaSelect.appendChild(opt);
                        });
                    }

                    function cargarDistritos() {
                        const provId = document.getElementById("provincia").value;
                        const distritoSelect = document.getElementById("distritoProv");
                        distritoSelect.innerHTML = "<option value=''>Distrito</option>";
                        distritos.filter(d => d.province_id === provId).forEach(dist => {
                            const opt = document.createElement("option");
                            opt.value = dist.id;
                            opt.textContent = dist.name;
                            distritoSelect.appendChild(opt);
                        });
                    }

                    function guardarDatos() {
                        ["formDelivery", "formRecojo", "formProvincia"].forEach(id => {
                            document.getElementById(id).classList.add("hidden");
                        });
                        document.getElementById("botonGuardarWrapper").classList.add("hidden");
                        document.getElementById("botonEditarWrapper").classList.remove("hidden");
                        mostrarResumen();
                    }

                    function editarDatos() {
                        const tipo = document.getElementById("entregaTipo").value;
                        if (tipo === "delivery") document.getElementById("formDelivery").classList.remove("hidden");
                        else if (tipo === "recojo") document.getElementById("formRecojo").classList.remove("hidden");
                        else if (tipo === "provincia") document.getElementById("formProvincia").classList.remove("hidden");

                        document.getElementById("botonGuardarWrapper").classList.remove("hidden");
                        document.getElementById("botonEditarWrapper").classList.add("hidden");
                    }


                    function iconoCheck(condicion) {
                        return condicion ? '<span class="inline-flex items-center justify-center w-4 h-4 ml-2 text-xs text-green-600 border border-green-500 rounded-full">✓</span>' : '';
                    }

                    function mostrarResumen() {
                        const tipo = document.getElementById("entregaTipo").value;
                        const resumen = document.getElementById("contenidoResumen");
                        let html = "";

                        if (tipo === "delivery") {
                            const direccion = document.getElementById("direccion").value;
                            const numero = document.getElementById("numero").value;
                            const referencia = document.getElementById("referencia").value;
                            const distrito = document.getElementById("distrito").value;

                            html = `<p><strong>Tipo:</strong> Delivery ${iconoCheck(true)}</p>
                            <p>Dirección: ${direccion || "—"}${iconoCheck(direccion)}, 
                            <p>Nº: ${numero || "—"} ${iconoCheck(numero)}, <p>
                            <p>Ref: ${referencia || "—"} ${iconoCheck(referencia)}</p>
                            <p>Distrito: ${distrito || "—"} ${iconoCheck(distrito)}</p>`;
                        } else if (tipo === "recojo") {
                            const fecha = document.getElementById("fechaRecojo").value;
                            const hora = document.getElementById("horaRecojo").value;
                            const sede = document.getElementById("sedeTienda").value;

                            html = `<p><strong>Tipo:</strong> Recojo en tienda ${iconoCheck(true)}</p>
        <p>Fecha: ${fecha || "—"} ${iconoCheck(fecha)}</p>
        <p>Hora: ${hora || "—"} ${iconoCheck(hora)}</p>
        <p>Sede: ${sede || "—"} ${iconoCheck(sede)}</p>`;
                        } else if (tipo === "provincia") {
                            const empresa = document.getElementById("empresaEnvio").value;
                            const depId = document.getElementById("departamento").value;
                            const provId = document.getElementById("provincia").value;
                            const distId = document.getElementById("distritoProv").value;

                            const depNom = departamentos.find(d => d.id === depId)?.name || "—";
                            const provNom = provincias.find(p => p.id === provId)?.name || "—";
                            const distNom = distritos.find(d => d.id === distId)?.name || "—";

                            html = `<p><strong>Tipo:</strong> Envío a provincia ${iconoCheck(true)}</p>
        <p>Empresa: ${empresa || "—"} ${iconoCheck(empresa)}</p>
        <p>Departamento: ${depNom} ${iconoCheck(depId)}</p>
        <p>Provincia: ${provNom} ${iconoCheck(provId)}</p>
        <p>Distrito: ${distNom} ${iconoCheck(distId)}</p>`;
                        } else {
                            html = `<p class="italic text-gray-500">No se ha seleccionado ningún método de entrega</p>`;
                        }

                        resumen.innerHTML = html;
                    }
                </script>









                <div class="bg-white rounded-lg shadow-md p-6 relative group">
                    <button onclick="toggleEdit('pago')" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800">💳</button>
                    <h2 class="text-lg font-semibold mb-4">Método de pago</h2>
                    <div id="pagoDisplay">
                        <div class="flex items-center space-x-2">
                            <img src="{{ asset('images/logoyape.png') }}" class="w-6 h-6" alt="Yape">
                            <span>Yape</span>
                        </div>
                    </div>
                    <div id="pagoEdit" class="hidden">
                        <label class="flex items-center space-x-2">
                            <input id="pagoYape" type="radio" name="pago" value="yape" class="form-radio text-orange-500" checked>
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e6/Yape_Logo.png/64px-Yape_Logo.png" alt="Yape" class="w-5 h-5">
                            <span>Yape</span>
                        </label>
                    </div>
                </div>
            </section>

            <aside class="flex-[1] bg-white rounded-lg shadow-md p-6 w-full lg:w-96">
                <div id="resumenPedido" class="space-y-4">
                    <!-- Aquí se insertarán los productos -->
                </div>
                <div class="text-sm text-gray-700 mb-2 flex justify-between">
                    <span>Subtotal</span>
                    <span id="subtotalText" class="font-semibold">S/ 0.00</span>
                </div>
                <div class="text-sm text-gray-700 mb-2 flex justify-between">
                    <span>Envío</span>
                    <span id="envioText" class="font-semibold">S/ 0.00</span>
                </div>
                <div class="text-lg font-bold text-gray-900 flex justify-between">
                    <span>Total</span>
                    <span id="totalText">S/ 0.00</span>
                </div>
            </aside>
        </div>

        <!-- Modal de pago con Yape -->
        <div id="modalYape" class="fixed inset-0 bg-black bg-opacity-50 z-[9999] hidden items-center justify-center">
            <div class="bg-white rounded-lg p-6 max-w-sm w-full relative">
                <button onclick="cerrarModalYape()" class="absolute top-2 right-2 text-gray-500 hover:text-black text-lg">✕</button>
                <h2 class="text-lg font-semibold mb-2 text-center">Paga con Yape</h2>
                <p class="text-sm text-center text-gray-700 mb-2">Escanea el siguiente QR:</p>
                <img src="{{ asset('images/yapep.jpg') }}" alt="QR Yape" class="mx-auto w-40 h-40 rounded border border-gray-300">
                <p class="text-center text-sm text-gray-600 mb-4">Titular: <strong>Jose Chavez C.</strong></p>

                <div class="flex items-end gap-4 mt-4">
                    <!-- Contenedor del código en 3 cuadros pequeños -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Código de operación</label>
                        <div class="flex gap-1">
                            <input type="text" maxlength="1" class="codigoBox w-10 h-10 text-center border border-gray-300 rounded-md text-base focus:outline-none" />
                            <input type="text" maxlength="1" class="codigoBox w-10 h-10 text-center border border-gray-300 rounded-md text-base focus:outline-none" />
                            <input type="text" maxlength="1" class="codigoBox w-10 h-10 text-center border border-gray-300 rounded-md text-base focus:outline-none" />
                        </div>
                    </div>

                    <!-- Contenedor de la fecha -->
                    <div class="flex-1">
                        <label for="fechaPago" class="block text-sm font-medium text-gray-700 mb-1">Fecha del pago</label>
                        <input type="date" id="fechaPago"
                            class="w-full h-10 text-base border border-gray-300 rounded-md px-3 focus:outline-none" />
                    </div>
                </div>

                <!-- Campo para subir comprobante -->
                <div class="mt-4">
                    <label for="comprobanteYape" class="block text-sm font-medium text-gray-700 mb-1">Sube tu comprobante</label>
                    <input type="file" id="comprobanteYape" accept="image/*"
                        class="w-full h-10 text-base border border-gray-300 rounded-md px-3 py-1.5 focus:outline-none" />
                </div>
                <div id="previewYape" class="mt-2 text-center"></div>


                <button onclick="enviarPagoYape()" class="mt-4 w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded">
                    Enviar comprobante
                </button>
            </div>
        </div>

    </main>

    <footer class="bg-white p-4 shadow-md fixed bottom-0 left-0 w-full z-50">
        <div class="container mx-auto flex justify-end">
            <button onclick="validarFormulario()" class="bg-red-600 text-white font-bold py-3 px-6 rounded-full flex items-center space-x-2 hover:bg-red-700 transition duration-300 shadow-md">
                <span>Finalizar compra</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                </svg>
            </button>
        </div>
    </footer>



    <script>
        const boxes = document.querySelectorAll('.codigoBox');

        boxes.forEach((box, i) => {
            box.addEventListener('input', (e) => {
                const value = e.target.value;
                if (!/^\d?$/.test(value)) {
                    e.target.value = ''; // solo permite 1 número
                    return;
                }

                // Avanza al siguiente automáticamente
                if (value && i < boxes.length - 1) {
                    boxes[i + 1].focus();
                }

                // Cambiar a verde claro si todos tienen número
                const completo = Array.from(boxes).every(b => /^\d$/.test(b.value));
                boxes.forEach(b => {
                    b.style.backgroundColor = completo ? '#d1fae5' : 'white'; // verde claro si está completo
                });
            });

            // Retrocede si borras con Backspace
            box.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !box.value && i > 0) {
                    boxes[i - 1].focus();
                }
            });
        });
    </script>
    <script>
        function toggleEdit(seccion) {
            const view = document.getElementById(`${seccion}Display`);
            const edit = document.getElementById(`${seccion}Edit`);
            if (edit.classList.contains('hidden')) {
                edit.classList.remove('hidden');
                view.classList.add('hidden');
            } else {
                if (seccion === 'titular') {
                    document.getElementById('viewTitularNombre').innerText = document.getElementById('titularNombre').value;
                    document.getElementById('viewTitularDNI').innerText = document.getElementById('titularDNI').value;
                    document.getElementById('viewTitularTelefono').innerText = document.getElementById('titularTelefono').value;
                    document.getElementById('viewTitularCorreo').innerText = document.getElementById('titularCorreo').value;
                } else if (seccion === 'entrega') {
                    document.getElementById('viewEntregaTipo').innerText = document.getElementById('entregaTipo').value;
                    document.getElementById('viewEntregaFecha').innerText = document.getElementById('entregaFecha').value;
                    document.getElementById('viewEntregaDireccion').innerText = document.getElementById('entregaDireccion').value;
                    document.getElementById('viewEntregaUbicacion').innerText = document.getElementById('entregaUbicacion').value;
                }
                edit.classList.add('hidden');
                view.classList.remove('hidden');
            }
        }

        function cargarResumenPedido() {
            const resumen = document.getElementById('resumenPedido');
            const subtotalText = document.getElementById('subtotalText');
            const totalText = document.getElementById('totalText');
            const carter = JSON.parse(localStorage.getItem('carter')) || [];

            let total = 0;
            resumen.innerHTML = '';

            carter.forEach(item => {
                const subtotal = item.precio * item.cantidad;
                total += subtotal;
                resumen.innerHTML += `
          <div class="flex items-start space-x-4 border-b border-gray-200 pb-2">
            <img src="${item.imagen}" alt="${item.nombre}" class="w-16 h-16 object-contain rounded">
            <div class="flex-1">
              <p class="font-medium text-sm text-gray-800">${item.nombre} (${item.talla || 'Talla única'})</p>
              <p class="text-xs text-gray-600">${item.cantidad} x S/ ${item.precio.toFixed(2)}</p>
              <p class="font-semibold text-sm text-gray-900">Subtotal: S/ ${(subtotal).toFixed(2)}</p>
            </div>
          </div>
        `;
            });

            subtotalText.textContent = `S/ ${total.toFixed(2)}`;
            totalText.textContent = `S/ ${total.toFixed(2)}`;
        }

        function validarFormulario() {
            alert("Compra finalizada exitosamente");
        }

        window.onload = cargarResumenPedido;
    </script>





    <script>
        function abrirModalYape() {
            document.getElementById('modalYape').classList.remove('hidden');
            document.getElementById('modalYape').classList.add('flex');
        }

        function cerrarModalYape() {
            document.getElementById('modalYape').classList.add('hidden');
            document.getElementById('modalYape').classList.remove('flex');
        }

        function validarFormulario() {
            abrirModalYape();
        }

        document.getElementById('comprobanteYape').addEventListener('change', function() {
            const file = this.files[0];
            const preview = document.getElementById('previewYape');
            preview.innerHTML = '';

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-24 mx-auto rounded border';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });

        async function enviarPagoYape() {
            const file = document.getElementById('comprobanteYape').files[0];
            const codigoBoxes = document.querySelectorAll('.codigoBox');
            const fecha = document.getElementById('fechaPago').value;
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Unir los códigos de operación en un solo string
            const codigo = Array.from(codigoBoxes).map(b => b.value).join('');

            // Validaciones básicas
            if (!file) return alert('⚠️ Debes subir un comprobante.');
            if (!codigo || codigo.length < 3) return alert('⚠️ Ingresa el código de operación completo.');
            if (!fecha) return alert('⚠️ Debes ingresar la fecha del pago.');

            // Obtener productos desde el localStorage
            const productos = JSON.parse(localStorage.getItem('carter') || '[]');
            if (productos.length === 0) return alert('⚠️ No hay productos en el carrito.');

            // Obtener método de entrega y datos
            const entregaTipo = document.getElementById('entregaTipo').value;
            let entregaData = {};

            if (entregaTipo === 'delivery') {
                entregaData = {
                    direccion: document.getElementById('direccion').value,
                    numero: document.getElementById('numero').value,
                    referencia: document.getElementById('referencia').value,
                    distrito: document.getElementById('distrito').value
                };
            } else if (entregaTipo === 'recojo') {
                entregaData = {
                    fecha: document.getElementById('fechaRecojo').value,
                    hora: document.getElementById('horaRecojo').value,
                    sede: document.getElementById('sedeTienda').value
                };
            } else if (entregaTipo === 'provincia') {
                entregaData = {
                    empresa: document.getElementById('empresaEnvio').value,
                    departamento: document.getElementById('departamento').value,
                    provincia: document.getElementById('provincia').value,
                    distrito: document.getElementById('distritoProv').value
                };
            }

            const formData = new FormData();
            formData.append('payment_method', 'yape');
            formData.append('payment_code', codigo);
            formData.append('payment_date', fecha);
            formData.append('delivery_method', entregaTipo);
            formData.append('delivery_data', JSON.stringify(entregaData));
            formData.append('productos', JSON.stringify(productos));
            formData.append('comprobante', file);
            formData.append('_token', csrf); // CSRF token

            try {
                const res = await fetch('/checkout/guardar', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const data = await res.json();
                if (data.success) {
                    alert('✅ Pedido enviado correctamente');
                    localStorage.removeItem('carter'); // limpia carrito
                    window.location.href = '/'; // redirige si deseas
                } else {
                    alert('❌ Error: ' + data.message);
                }
            } catch (error) {
                console.error('Error al enviar:', error);
                alert('❌ Error inesperado. Intenta nuevamente.');
            }
        }
    </script>


</body>

@php
$user = Auth::user();
@endphp

</html>