//Muestra el valor hexdecimal del color segun la clase text-color
import { hexcolor } from "@/views/pages/private/maintainers/frontUtils/colors";

export const setColorSample = function (colorSelected) {
    let colorHex = null;
    if (colorSelected && hexcolor) {
       const filterColor = hexcolor.find(item => item.id == colorSelected.id);
       colorHex = filterColor?.name ?? null;  
    }
    return colorHex;
}