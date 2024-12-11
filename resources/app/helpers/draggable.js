export const toggleAddItems = function (obj, parent,parentid) {
    obj.push({ id: `0000${obj.length + 1}`, order: obj.length + 1, [parent]:parentid, columns: [], width: 12 });
    updateOrder(obj);
}

export const updateOrder = function (obj, drag) {
    drag = false;
    obj.forEach((item, index) => {
        item.order = index + 1; // El orden comienza desde 1
    });
}

export const deleteItems = function (obj, index) {
    obj.splice(index, 1);
    updateOrder(obj);
}


