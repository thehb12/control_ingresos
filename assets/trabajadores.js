import { async_fecth_form_data, sweetalert2, select, on, sweetalert2Server } from './util';

$('#table_trabajadores').bootstrapTable({
  columns: [{
    field: 'state',
    checkbox: true,
    title: ' Check'
  }, {
    field: 'id',
    title: ' ID'
  }, {
    field: 'nombre',
    title: 'Nombre Completo'
  }, {
    field: 'cedula',
    title: 'Cedula'
  }, {
    field: 'cargo',
    title: 'Cargo'
  }, {
    field: 'celular',
    title: 'Celular'
  }],
  clickToSelect: true,
  search: true,
  showRefresh: true,
  pagination: true,
  pageSize: 10,
  locale:"es-ES",
  url: '/trabajadores/pagination',
  buttons: buttons,
});

function buttons() {
  return {
    btnUsersAdd: {
      text: 'Highlight Users',
      icon: 'bi-pencil-square',
      event: () => {
        let data = $('#table_trabajadores').bootstrapTable('getSelections')
        select('#id').value=data[0].id;
        select('#nombre').value=data[0].nombre;
        select('#cargo').value=data[0].cargo;
        select('#celular').value=data[0].celular;
        select('#cedula').value=data[0].cedula;    

      },
      attributes: {
        title: 'Editar Trabajador'
      }
    },
    btnUsersDelete: {
      text: 'Highlight Users',
      icon: 'bi-trash',
      event: async () => {
        let dataRow = $('#table_trabajadores').bootstrapTable('getSelections');
        const data = new FormData();
        data.append('id', dataRow[0].id);
        const resp = await async_fecth_form_data('/trabajadores/borrar', data);
        sweetalert2Server(resp.result.mensaje);
        $('#table_trabajadores').bootstrapTable('refresh');
      },
      attributes: {
        title: 'Eliminar'
      }
    }
  }
}

on('submit', '#form_trabajador', async (e) => {
  e.preventDefault();
  const data = new FormData(e.target);
  const resp = await async_fecth_form_data('/trabajadores/agregar', data)
  sweetalert2Server(resp.result.mensaje);
  $('#table_trabajadores').bootstrapTable('refresh');
  e.target.reset();
})

document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('btn_reset_form').addEventListener('click', function() {
    document.getElementById('form_trabajador').reset(); // Resetea el formulario
    // Aquí puedes agregar cualquier acción adicional que necesites
  });
});