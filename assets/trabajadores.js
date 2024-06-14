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
  url: rutas.app_trabajadores_pagination,
  buttons: buttons,
});

function buttons() {
  return {
    btnUsersAdd: {
      text: 'Highlight Users',
      icon: 'bi-pencil-square',
      event: () => {
        let data = $('#table_trabajadores').bootstrapTable('getSelections')
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
        data.append('cedula', dataRow[0].cedula);
        const resp = await async_fecth_form_data(rutas.app_trabajadores_borrar, data);
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
  const resp = await async_fecth_form_data(rutas.app_trabajadores_agregar, data)
  sweetalert2Server(resp.result.mensaje);
  $('#table_trabajadores').bootstrapTable('refresh');
  e.target.reset();
})