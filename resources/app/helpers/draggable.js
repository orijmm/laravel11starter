export const toggleAddItems = function (obj, parent,parentid) {
    obj.rows.push({ id: `0000${obj.rows.length + 1}`, order: obj.rows.length + 1, [parent]:parentid, columns: [] });
    updateOrder(obj);
}

export const updateOrder = function (obj, drag) {
    drag = false;
    obj.rows.forEach((item, index) => {
        item.order = index + 1; // El orden comienza desde 1
    });
}

export const deleteItems = function (obj, index) {
    obj.rows.splice(index, 1);
}


