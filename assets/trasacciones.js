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
    showExport: true,
    sidePagination:"server", 
    exportTypes: ['excel'],
    pageList:"[5,10, 25, 50, 100, all]",
    url: '/trasacciones/pagination/',
    buttons: buttons
    
  });

  function buttons() {
    return {
      btnUsersAdd: {
        text: 'Highlight Users',
        icon: 'bi-pencil-square',
        event: () => {
          let data = $('#table_trasacciones').bootstrapTable('getSelections')
          select('#cedula').value=data[0].cedula;    
  
        },
        attributes: {
          title: 'Editar Trabajador'
        }
      }  
    }
  }

  on('submit', '#form_trasaccion', async (e) => {
    e.preventDefault();
    const data = new FormData(e.target);
    const resp = await async_fecth_form_data('/trasacciones/agregar', data)
    sweetalert2Server(resp.result.mensaje);
    $('#table_trasacciones').bootstrapTable('refresh');
    e.target.reset();
  });