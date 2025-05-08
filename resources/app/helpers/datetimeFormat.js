// agregar ... en parrafo que supera lenght
import moment from "moment/moment";
import 'moment/locale/es'; // importante: cargar el locale
moment.locale('es');

export const date = function (date, format = 'DD-MM-YYYY') {
    const momentDate = moment(date, ['YYYY-MM-DD', 'DD-MM-YYYY', 'MM-DD-YYYY', 'DD/MM/YYYY', 'MM/DD/YYYY', 'YYYY/MM/DD'], true);
    if (momentDate.isValid()) {
        return momentDate.format(format);
    } else {
        return date;
    }
}

