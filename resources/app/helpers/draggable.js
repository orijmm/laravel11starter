export const toggleAddItems = function (obj, parent,parentid) {
    obj.push({ id: `xxxx${obj.length + 1}`, order: obj.length + 1, [parent]:parentid, columns: [], width: 12 });
    updateOrder(obj);
}

export const updateOrder = function (obj, drag) {
    const cols = {
        1: 12,
        2: 6,
        3: 4,
        4: 3,
        5: 1,
        6: 2,
        7: 1,
        8: 1,
        9: 1,
        10: 1,
        12: 1
    };

    drag = false;
    obj.forEach((item, index) => {
        item.order = index + 1; // El orden comienza desde 1
        item.width = cols[obj.length];
    });
}

export const deleteItems = function (obj, index) {
    obj.splice(index, 1);
    updateOrder(obj);
}


