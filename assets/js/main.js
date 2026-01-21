// Reacciona cuando se elige una bodega con la intención de obtener las sucursales de acuerdo a la bodega elegida
document.getElementById("bodega").addEventListener("change", function () {
  const sucursalSelect = document.getElementById("sucursal");
  sucursalSelect.innerHTML = '<option value="">Cargando...</option>';

  if (!this.value) {
    sucursalSelect.disabled = true;
    return;
  }

  fetch(`api/get_sucursales.php?bodega_id=${this.value}`)
    .then((res) => res.json())
    .then((data) => {
      sucursalSelect.innerHTML = '<option value=""></option>';
      data.forEach((s) => {
        sucursalSelect.innerHTML += `<option value="${s.id}">${s.nombre}</option>`;
      });
      sucursalSelect.disabled = false;
    });
});

document.getElementById("productForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);

  const campos = [
    {
      name: "codigo",
      label: "Código",
      error: "El código del producto no puede estar en blanco.",
    },
    {
      name: "nombre",
      label: "Nombre",
      error: "El nombre del producto no puede estar en blanco.",
    },
    {
      name: "bodega",
      label: "Bodega",
      error: "Debe seleccionar una bodega.",
    },
    {
      name: "sucursal",
      label: "Sucursal",
      error: "Debe seleccionar una sucursal para la bodega seleccionada.",
    },
    {
      name: "moneda",
      label: "Moneda",
      error: "Debe seleccionar una moneda para el producto.",
    },
    {
      name: "precio",
      label: "Precio",
      error: "El precio del producto no puede estar en blanco.",
    },
    {
      name: "descripcion",
      label: "Descripción",
      error: "La descripción del producto no puede estar en blanco.",
    },
  ];

  // Chequeo de campos obligatorios
  for (const campo of campos) {
    const valor = formData.get(campo.name);
    if (!valor || valor.trim() === "") {
      alert(campo.error);
      return;
    }
  }

  // Chequeos del codigo
  const codigo = formData.get("codigo").trim();

  if (codigo.length < 5 || codigo.length > 15) {
    alert("El código del producto debe tener entre 5 y 15 caracteres.");
    return;
  }

  const isAlphanumeric = /^[a-zA-Z0-9]+$/;
  if (!isAlphanumeric.test(codigo)) {
    alert("El código del producto debe contener letras y números.");
    return;
  }

  const hasLetter = /[a-zA-Z]/.test(codigo);
  const hasNumber = /[0-9]/.test(codigo);
  if (!hasLetter || !hasNumber) {
    alert(
      "El código del producto debe contener al menos una letra y un número.",
    );
    return;
  }

  // Chequeo del nombre
  const nombre = formData.get("nombre").trim();
  if (nombre.length < 2 || nombre.length > 50) {
    alert("El nombre del producto debe tener entre 2 y 50 caracteres.");
    return;
  }

  // Chequeo del precio
  const precioRegEx = /^\d+(\.\d{1,2})?$/;
  const precio = formData.get("precio");
  if (!precioRegEx.test(precio) || parseFloat(precio) <= 0) {
    alert(
      "El precio del producto debe ser un número positivo con hasta dos decimales.",
    );
    return;
  }

  // Chequeo de minimo dos materiales seleccionados
  const materiales = formData.getAll("material[]");
  if (materiales.length < 2) {
    alert("Debe seleccionar al menos dos materiales del producto.");
    return;
  }

  // Chequeo de la descripción
  const descripcion = formData.get("descripcion");
  if (descripcion.length < 10 || descripcion.length > 1000) {
    alert("La descripción del producto debe tener entre 10 y 1000 caracteres.");
    return;
  }

  // 7. Si todo está OK, enviamos por AJAX
  enviarFormulario(formData);
});

function enviarFormulario(formData) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "api/save_product.php", true);

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var data = JSON.parse(xhr.responseText);
      if (data.success) {
        alert("¡Guardado con éxito!");
      } else {
        alert("Error: " + data.message);
      }
    }
  };

  xhr.send(formData);
}
