

// HEXAGON GRID
function hexagonGrid() {
  const HEXAGON_GRID = document.getElementById("hexagonGrid");
  const CONTAINER = HEXAGON_GRID.parentNode;

  let wall = {
    width: CONTAINER.offsetWidth,
    height: CONTAINER.offsetHeight
  };

  let rowsNumber = Math.ceil(wall.height / 80);
  let columnsNumber = Math.ceil(wall.width / 100) + 1;

  HEXAGON_GRID.innerHTML = "";

  for (let i = 0; i < rowsNumber; i++) {
    let row = document.createElement("div");
    row.className = "row";
    HEXAGON_GRID.appendChild(row);
  }

  let rows = HEXAGON_GRID.querySelectorAll(".row");

  for (let i = 0; i < rows.length; i++) {
    for (let j = 0; j < columnsNumber; j++) {
      let hexagon = document.createElement("div");
      hexagon.className = "hexagon";
      rows[i].appendChild(hexagon);
    }
  }
}

hexagonGrid();

