import 'bootstrap';
import 'bootstrap-table';
import 'bootstrap-table/dist/extensions/export/bootstrap-table-export';
import 'tableexport.jquery.plugin';
import 'sweetalert2/src/sweetalert2.scss';
import './styles/app.scss';
import './main';

class Carro {
    constructor(marca, modelo, año) {
        this.marca = marca;
        this.modelo = modelo;
        this.año = año;
    }

    // Método para obtener la información del carro
    obtenerInfo() {
        return `${this.marca} ${this.modelo} (${this.año})`;
    }

    // Método para encender el carro
    encender() {
        return `${this.marca} ${this.modelo} está encendido.`;
    }

    // Método para apagar el carro
    apagar() {
        return `${this.marca} ${this.modelo} está apagado.`;
    }
}



class Camion extends Carro {
    constructor(marca, modelo, año, tonelaje) {
        super(marca, modelo, año); // Llama al constructor de la clase padre
        this.tonelaje = tonelaje;
    }
}


let dobletruck = new Camion()
dobletruck.obtenerInfo()


let dobletruck2 = new Camion()
dobletruck2.obtenerInfo()