import { async_fecth_form_data, sweetalert2, select, on, sweetalert2Server } from './util';

$('#table_trasacciones').bootstrapTable({
    columns: [{
      field: 'state',
      checkbox: true,
      title: ' Check'
    }, {
      field: 'id',
      title: ' ID'
    }, {
      field: 'nombre',
      title: 'Nombre'
    }, {
      field: 'cedula',
      title: 'Cedula',
    }, {
      field: 'fecha_entrada',
      title: 'Fecha_Entrada'
    }, {
      field: 'fecha_salida',
      title: 'Fecha_Salida'
    },{
        field: 'estado',
        title: 'Estado'
    }],
    clickToSelect: true,
    search: true,
    showRefresh: true,
    pagination: true,
    pageSize: 10,
    url: '/trasacciones/pagination',
   buttons: buttons,
  });
  function buttons() {
    return {btnUsersDelete: {
      text: 'Highlight Users',
      icon: 'bi-trash',
      event: async () => {
        let dataRow = $('#table_trasacciones').bootstrapTable('getSelections');
        const data = new FormData();
        data.append('cedula', dataRow[0].cedula);
        const resp = await async_fecth_form_data(rutas.app_trasacciones_borrar, data);
        sweetalert2Server(resp.result.mensaje);
        $('#table_trasacciones').bootstrapTable('refresh');
      },
      attributes: {
        title: 'Eliminar'
      }
    }
  }
}

  on('submit', '#form_trasaccion', async (e) => {
    e.preventDefault();
    const data = new FormData(e.target);
    const resp = await async_fecth_form_data(rutas.app_trasacciones_agregar, data)
    sweetalert2Server(resp.result.mensaje);
    $('#table_trasacciones').bootstrapTable('refresh');
    e.target.reset();
  });