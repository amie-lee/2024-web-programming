import elements from './elements.js';
import data from './data.js';

const {divMenu, form, userName, level, rulesButton, rulesContent, rulesClose, divGame, divGameOver} = elements;
const {easyMaps, hardMaps} = data;

let timerInterval;
let timeElapsed = 0;

let mapData = [];
let leaderBoard = [];

for (let i=0; i<localStorage.length; i++) {
    leaderBoard.push(JSON.parse(localStorage.getItem(i)));
}


export function init() {
    addEventListeners();
}

function addEventListeners() {
    // Menu
    rulesButton.addEventListener("click", () => {
        rulesContent.style.display = "block";
    });
    rulesClose.addEventListener("click", () => {
        rulesContent.style.display = "none";
    });

    // Set Game screen
    form.addEventListener("submit", e => {
        e.preventDefault();

        divMenu.style.display = "none";
        divGame.style.display = "flex";

        divGame.innerHTML = `
            <div id="side">
                <p>ROUTE DESIGNER:<br><span id="name-span">${userName.value.toUpperCase()}</span></p>
                <p>ELAPSED TIME:<br><span id="time-span">00:00</span></p>
                <img id="straight" src="/sources/tiles/straight_rail.png">
                <img id="curve" src="/sources/tiles/curve_rail.png">
            </div>
            ${renderMap()}
        `;

        const timer = document.querySelector("#time-span");

        timeElapsed = 0;
        timer.textContent = timeElapsed;
        timerInterval = setInterval(() => {
            timeElapsed++;

            const minutes = Math.floor(timeElapsed / 60);
            const seconds = timeElapsed % 60;

            timer.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }, 1000);
    });

    // Placement
    divGame.addEventListener("dragstart", e => {
        if (e.target.matches("#side img")) {
            e.dataTransfer.setData('src', e.target.src);
            e.dataTransfer.setData('rail', e.target.id);
        }
    });
    divGame.addEventListener("dragover", e => {
        if (e.target.matches("#map-table img")) {
            e.preventDefault();
        }
    });
    divGame.addEventListener("drop", e => {
        if (e.target.matches("#map-table img")) {
            e.preventDefault();

            const imgSrc = e.dataTransfer.getData('src');
            const railType = e.dataTransfer.getData('rail');

            const td = e.target.parentNode;
            const tr = td.parentNode;
            const i = tr.rowIndex;
            const j = td.cellIndex;

            if (mapData[i][j].isRail) return;

            mapData[i][j].tile = railType;
            mapData[i][j].isRail = true;
            
            if (imgSrc) {
                if (e.target.id==='empty') {
                    e.target.src = imgSrc;
                }
                else if (e.target.id==='bridge') {
                    if (railType==='straight') {
                        e.target.src = "/sources/tiles/bridge_rail.png";
                    }
                }
                else if (e.target.id==='bridge90') {
                    if (railType==='straight') {
                        e.target.src = "/sources/tiles/bridge_rail.png";
                        mapData[i][j].angle = 90;
                    }
                }
                else if (e.target.id==='mountain') {
                    if (railType==='curve') {
                        e.target.src = "/sources/tiles/mountain_rail.png";
                    }
                }
                else if (e.target.id==='mountain90') {
                    if (railType==='curve') {
                        e.target.src = "/sources/tiles/mountain_rail.png";
                        mapData[i][j].angle = 90;
                    }
                }
                else if (e.target.id==='mountain180') {
                    if (railType==='curve') {
                        e.target.src = "/sources/tiles/mountain_rail.png";
                        mapData[i][j].angle = 180;
                    }
                }
                else if (e.target.id==='mountain270') {
                    if (railType==='curve') {
                        e.target.src = "/sources/tiles/mountain_rail.png";
                        mapData[i][j].angle = 270;
                    }
                }
            }

            isGameover();
        }
    });

    divGame.addEventListener("click", e => {
        if (e.target.matches("#map-table img")) {
            const td = e.target.parentNode;
            const tr = td.parentNode;
            const i = tr.rowIndex;
            const j = td.cellIndex;

            if (e.target.id==='empty') {
                let angle = parseInt(e.target.getAttribute("angle") || "0");
                angle = (angle+90) % 360;
                mapData[i][j].angle = angle;
                e.target.style.transform = `rotate(${angle}deg)`;
                e.target.setAttribute("angle", angle);
            }

            isGameover();
        }
    });
}


function setMap() {
    if ( level.value==='easy' ) {
        return easyMaps[Math.floor(Math.random() * easyMaps.length)]
    }
    else {
        return hardMaps[Math.floor(Math.random() * hardMaps.length)]
    }
}
function setTile(text) {
    if (text === "empty") return '<img id="empty" src="/sources/tiles/empty.png">'
    else if (text === "bridge") return '<img id="bridge" src="/sources/tiles/bridge.png">'
    else if (text === "bridge90") return '<img id="bridge90" src="/sources/tiles/bridge.png" style="transform:rotate(90deg);">'
    else if (text === "mountain") return '<img id="mountain" src="/sources/tiles/mountain.png">'
    else if (text === "mountain90") return '<img id="mountain90" src="/sources/tiles/mountain.png" style="transform:rotate(90deg);">'
    else if (text === "mountain180") return '<img id="mountain180" src="/sources/tiles/mountain.png" style="transform:rotate(180deg);">'
    else if (text === "mountain270") return '<img id="mountain270" src="/sources/tiles/mountain.png" style="transform:rotate(270deg);">'
    else if (text === "oasis") return '<img id="oasis" src="/sources/tiles/oasis.png">'
}
function renderMap() {
    const map = setMap();

    for (let i=0; i<map.length; i++) {
        mapData[i] = [];
        for (let j=0; j<map.length; j++) {
            mapData[i][j] = {
                tile: map[i][j],
                angle: 0,
                isRail: false,
                exit: [],
                isConnected: false
            }
        }
    }

    return `
        <table id="map-table">
        ${map.map(row => `
            <tr>
            ${row.map(cell => `
                <td id="${cell}">${setTile(cell)}</td>
            `).join("")}
            </tr>
        `).join("")}
        </table>
    `;
}

function isGameover() {

    // set exit point
    mapData.forEach(row => {
        row.forEach(cell => {
            if (cell.isRail) {
                if (cell.tile === 'straight') {
                    if (cell.angle === 0 || cell.angle === 180) { cell.exit = [1,3]; }
                    else if (cell.angle === 90 || cell.angle === 270) { cell.exit = [2,4]; }
                }
                else if (cell.tile === 'curve') {
                    if (cell.angle === 0) { cell.exit = [2,3]; }
                    else if (cell.angle === 90) { cell.exit = [3,4]; }
                    else if (cell.angle === 180) { cell.exit = [1,4]; }
                    else if (cell.angle === 270) { cell.exit = [1,2]; }
                }
            }
        });
    });

    // check continuity
    const directions = {
        1: [-1,0], // up
        2: [0,1], // right
        3: [1,0], // down
        4: [0,-1] // left
    }
    function nextCell(i, j, exit) {
        const [di, dj] = directions[exit];
        if (i+di<0 || i+di>=mapData.length || j+dj<0 || j+dj>=mapData.length) return 0;
        return mapData[i+di][j+dj];
    }
    function oppositeExit(n) {
        if (n===1) return 3;
        else if (n===2) return 4;
        else if (n===3) return 1;
        else if (n===4) return 2;
    }

    let rails = [];
    //console.log('-----');
    for (let i=0; i<mapData.length; i++) {
        for (let j=0; j<mapData.length; j++) {
            const cell = mapData[i][j];
            
            if (cell.isRail) {
                rails.push(cell);
                const next1 = nextCell(i,j,cell.exit[0]);
                const next2 = nextCell(i,j,cell.exit[1]);
                
                if (next1===0 || next2===0) return;
                
                if ( next1.isRail && next2.isRail && next1.exit.includes(oppositeExit(cell.exit[0])) && next2.exit.includes(oppositeExit(cell.exit[1])) ) {
                    cell.isConnected = true;
                    //console.log(cell);
                } else {
                    cell.isConnected = false;
                }
            }
        }
    }
    
    const allOK = mapData.every(r => 
        r.every(c => c.tile==='oasis' || c.isRail===true)
    );
    //console.log(allOK);

    // End of game
    if (rails.every(c => c.isConnected===true) && allOK) {

        leaderBoard.push({
            name: userName.value,
            time: document.querySelector("#time-span").textContent,
            level: level.value
        })

        leaderBoard.forEach((u, i) => {
            localStorage.setItem(i, JSON.stringify(u));
        })

        const filtered = leaderBoard.filter(u => u.level === level.value)
                .sort((a,b) => {
                    const [aMin, aSec] = a.time.split(':').map(Number);
                    const [bMin, bSec] = b.time.split(':').map(Number);
                    return (aMin*60+aSec) - (bMin*60+bSec);
                });

        divGameOver.innerHTML = setLeaderboard(filtered);

        setTimeout(function(){
            divGame.style.display = "none";
            divGameOver.style.display = "flex";
        }, 500);
        
    }
}

function setLeaderboard(l) {
    return `
            <p>RECORD | ${document.querySelector("#time-span").textContent}</p>
            <table id="leader-board">
                <tr>
                    <th>RANK</th>
                    <th>DESIGNER</th>
                    <th>TIME</th>
                    <th>LEVEL</th>
                </tr>
                ${l.map((u, i) => `
                    <tr>
                        <td>${i+1}</td>
                        <td>${u.name}</td>
                        <td>${u.time}</td>
                        <td>${u.level}</td>
                    </tr>
                `).join("")}
            </table>
        `;
}