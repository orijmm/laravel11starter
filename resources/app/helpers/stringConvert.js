export const truncate = function (str, len) {
    return str.length > len ? str.slice(0, len) + '…' : str
}

