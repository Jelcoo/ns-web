function initTable(elements, tableCols, data) {
    const chunkSize = 25;
    let currentChunk = 0;

    let chunks = chunkify(data);
    fill();

    if (elements.search) addSearchListener();
    addPageListener();

    function fill() {
        clearTable();
        fillTable();
        setPageDisplay();
    }

    function chunkify(raw) {
        const chunks = [];
        for (let i = 0; i < raw.length; i += chunkSize) {
            chunks.push(raw.slice(i, i + chunkSize));
        }
        return chunks;
    }

    function clearTable() {
        for (let i = elements.table.rows.length - 1; i > 0; i--) {
            elements.table.deleteRow(i);
        }
    }

    function fillTable() {
        chunks[currentChunk]?.forEach(data => {
            const row = elements.table.insertRow();
            tableCols.forEach(key => {
                const cell = row.insertCell();
                cell.innerHTML = data[key];
            });
        });
    }

    function setPageDisplay() {
        elements.pageDisplay.innerHTML = `Page <strong>${currentChunk + 1}</strong> of <strong>${Math.max(chunks.length, 1)}</strong>`;
    }

    function addSearchListener() {
        elements.search.addEventListener('input', () => {
            const query = elements.search.value;
            const filtered = search(query);
            chunks = chunkify(filtered);
            currentChunk = 0;
            fill();
        });

        function search(query) {
            const matched = [];
            data.forEach(key => {
                Object.values(key).forEach(value => {
                    if (typeof value === 'number') value = value.toString();
                    if (value.toLowerCase().includes(query.toLowerCase()) && !matched.includes(key)) matched.push(key);
                });
            });

            return matched;
        }
    }

    function addPageListener() {
        elements.back.addEventListener('click', () => {
            if (currentChunk > 0) {
                currentChunk--;
                fill();
            }
        });
        elements.next.addEventListener('click', () => {
            if (currentChunk < chunks.length - 1) {
                currentChunk++;
                fill();
            }
        });
    }
}
