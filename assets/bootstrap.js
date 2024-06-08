

$('#table').bootstrapTable({
    columns: [{
        field: 'id',
        title: ' ID'
    }, {
        field: 'full_name',
        title: 'Nombre Completo'
    }, {
        field: 'check_in',
        title: 'Hora de llegada'
    }, {
        field: 'departure_time',
        title: 'Hora de salida',
    }],
    data: [{
        id: 1,
        full_name: 'Tania Milena Medina Florez',
        check_in: '8:00 AM',
        departure_time: '12:00 PM',
    }, {
        id: 1,
        full_name: 'Tania Milena Medina Florez',
        check_in: '2:00 PM',
        departure_time: '6:00 PM',
    }, {
        id: 2,
        full_name: 'Alexandra Villalobos Arias ',
        check_in: '6:00 AM',
        departure_time: '2:00 PM',
    }, {
        id: 3,
        full_name: 'Sandra Milena Carrillo Lizarazo  ',
        check_in: '8:00 AM',
        departure_time: '12:00 PM',
    }, {
        id: 3,
        full_name: 'Sandra Milena Carrillo Lizarazo  ',
        check_in: '2:00 AM',
        departure_time: '6:00 PM',
    }, ]
});
console.log(1)