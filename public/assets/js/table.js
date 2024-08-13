function chunkify(data, chunkSize) {
    const chunks = [];
    for (let i = 0; i < data.length; i += chunkSize) {
        chunks.push(data.slice(i, i + chunkSize));
    }
    return chunks;
}

function fillTable(table, chunks, currentChunk, keys, pageDisplay) {
    for (let i = table.rows.length - 1; i > 0; i--) {
        table.deleteRow(i);
    }
    chunks[currentChunk]?.forEach(data => {
        const row = table.insertRow();
        keys.forEach(key => {
            const cell = row.insertCell();
            cell.innerHTML = data[key];
        });
    });

    pageDisplay.innerHTML = `Page <strong>${currentChunk + 1}</strong> of <strong>${Math.max(chunks.length, 1)}</strong>`;
}

function search(query, data) {
    const matched = [];
    data.forEach(key => {
        Object.values(key).forEach(value => {
            if (typeof value === 'number') {
                value = value.toString();
            }
            if (value.toLowerCase().includes(query.toLowerCase())) {
                if (!matched.includes(key))
                matched.push(key);
            }
        });
    });

    return matched;
}
