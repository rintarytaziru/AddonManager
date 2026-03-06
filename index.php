<?php include "./constant.php" ?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Minecraft Bedrock Mod Selector</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
  <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/3.0.0/uicons-bold-rounded/css/uicons-bold-rounded.css">
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/3.0.0/uicons-brands/css/uicons-brands.css'>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=close,warning" />
  <style>::selection {
    background: #2e7520;
    color: #fff;
  }
  
  /* Light Mode Scrollbar */
  ::-webkit-scrollbar {
    width: 10px;
    height: 10px;
  }
  
  ::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
  }
  
  ::-webkit-scrollbar-thumb {
    background: rgba(100, 100, 100, 0.5);
    border-radius: 5px;
    border: 2px solid rgba(255, 255, 255, 0.1);
  }
  
  ::-webkit-scrollbar-thumb:hover {
    background: rgba(80, 80, 80, 0.8);
  }
  
  /* Dark Mode Scrollbar */
  .dark ::-webkit-scrollbar {
    width: 10px;
    height: 10px;
  }
  
  .dark ::-webkit-scrollbar-track {
    background: rgba(30, 30, 30, 0.5);
  }
  
  .dark ::-webkit-scrollbar-thumb {
    background: rgba(150, 150, 150, 0.5);
    border-radius: 5px;
    border: 2px solid rgba(50, 50, 50, 0.3);
  }
  
  .dark ::-webkit-scrollbar-thumb:hover {
    background: rgba(180, 180, 180, 0.8);
  }
  
  /* Firefox Scrollbar - Light */
  * {
    scrollbar-color: rgba(100, 100, 100, 0.5) rgba(255, 255, 255, 0.1);
    scrollbar-width: thin;
  }
  
  /* Firefox Scrollbar - Dark */
  .dark {
    scrollbar-color: rgba(150, 150, 150, 0.5) rgba(30, 30, 30, 0.5);
  }
  
  body {
    background: url(<?= $config["image_background"] ?>);
    background-attachment: fixed;
    background-size: cover;
  }
  </style>
  <script>
    if (localStorage.getItem('darkMode') === 'true') {
      document.documentElement.classList.add('dark');
    }
  </script>
</head>
<body class="min-h-screen backdrop-blur-sm bg-white/30 dark:bg-gray-900/50">
  <div class="min-h-screen">
  <!-- Dark Mode Toggle -->
    <div class="fixed top-4 right-4 z-40">
      <button id="darkModeToggle" class="p-2 rounded-lg bg-white/40 dark:bg-gray-800/40 hover:bg-white/60 dark:hover:bg-gray-700/60 transition">
        <i class="fi fi-br-sun text-yellow-500 dark:hidden"></i>
        <i class="fi fi-br-moon text-blue-300 hidden dark:inline"></i>
      </button>
    </div>

    <!-- Layout 2 cột -->
    <div class="grid md:grid-cols-2 gap-1 mb-4 m-4">
      <!-- Resource Packs -->
      <div class="bg-white/40 dark:bg-gray-800/40 h-full rounded-md overflow-hidden min-h-[280px]">
        <div class="overflow-y-scroll h-full max-h-[400px] p-1">
          <h2 class="text-xl font-semibold mb-3 p-3 bg-white/90 dark:bg-gray-700/90 dark:text-white inline-block rounded-md">Resource Packs</h2>
          <div id="resource_packs" class="space-y-2"></div>
        </div>
      </div>

      <!-- Behavior Packs -->
      <div class="bg-white/40 dark:bg-gray-800/40 h-full rounded-md overflow-hidden min-h-[280px]">
        <div class="overflow-y-scroll h-full max-h-[400px] p-1">
          <h2 class="text-xl font-semibold mb-3 p-3 bg-white/90 dark:bg-gray-700/90 dark:text-white inline-block rounded-md">Behavior Packs</h2>
          <div id="behavior_packs" class="space-y-2"></div>
        </div>
      </div>
    </div>

    <!-- Added -->
    <div class="grid md:grid-cols-2 gap-1 m-4">
      <div class="bg-white/40 dark:bg-gray-800/40 h-full rounded-md overflow-hidden min-h-[280px]">
        <div class="overflow-y-scroll h-full max-h-[400px] p-1">
          <h3 class="text-lg font-medium mb-2 p-3 bg-white/90 dark:bg-gray-700/90 dark:text-white inline-block rounded-md">Resource</h3>
          <div id="added_resource" class="space-y-2 dark:text-gray-300">Resource Pack Loading..</div>
        </div>
      </div>
      <div class="bg-white/40 dark:bg-gray-800/40 h-full rounded-md overflow-hidden min-h-[280px]">
        <div class="overflow-y-scroll h-full max-h-[400px] p-1">
          <h3 class="text-lg font-medium mb-2 p-3 bg-white/90 dark:bg-gray-700/90 dark:text-white inline-block rounded-md">Behavior</h3>
          <div id="added_behavior" class="space-y-2 dark:text-gray-300">Behavior Pack Loading..</div>
        </div>
      </div>
    </div>
  </div>

<footer class="w-full bg-gray-900 dark:bg-gray-950 text-white py-4">
  <div class="max-w-5xl mx-auto flex flex-col md:flex-row justify-between items-center gap-3 text-sm px-4">
    
    <!-- Bản quyền -->
    <div class="text-center md:text-left">
      Minecraft Mini Addons Manager © 2025 RintaryTaziru. All rights reserved.
    </div>

    <!-- Links GitHub -->
    <div class="flex flex-col md:flex-row items-center gap-2 md:gap-4 text-center">
      <a href="https://github.com/RintaryTaziru" target="_blank" class="flex items-center gap-1 text-blue-400 hover:underline">
        <i class="fi fi-brands-github"></i> Profile
      </a>
      <a href="https://github.com/RintaryTaziru/<Tên-Repo>" target="_blank" class="flex items-center gap-1 text-blue-400 hover:underline">
        <i class="fi fi-brands-github"></i> Repository
      </a>
    </div>

    

  </div>



</footer>

  <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

  <script>
    // Dark Mode Toggle
    const darkModeToggle = document.getElementById('darkModeToggle');
    darkModeToggle.addEventListener('click', () => {
      document.documentElement.classList.toggle('dark');
      const isDark = document.documentElement.classList.contains('dark');
      localStorage.setItem('darkMode', isDark);
    });

    const minecraft_colors = {
      '0': '#000000', // Black
      '1': '#0000AA', // Dark Blue
      '2': '#00AA00', // Dark Green
      '3': '#00AAAA', // Dark Aqua
      '4': '#AA0000', // Dark Red
      '5': '#AA00AA', // Dark Purple
      '6': '#FFAA00', // Gold
      '7': '#AAAAAA', // Gray
      '8': '#555555', // Dark Gray
      '9': '#5555FF', // Blue
      'a': '#55FF55', // Green
      'b': '#55FFFF', // Aqua
      'c': '#FF5555', // Red
      'd': '#FF55FF', // Light Purple
      'e': '#FFFF55', // Yellow
      'f': '#FFFFFF', // White
    };

    const minecraft_formats = {
      'l': 'font-weight:bold;',
      'o': 'font-style:italic;',
      'n': 'text-decoration:underline;',
      'm': 'text-decoration:line-through;',
      'r': 'reset'
    };

    const notyf = new Notyf({
      duration: 2000,
      position: {
        x: 'right',
        y: 'top',
      },
      types: [
        {
          type: 'warn',
          background: 'orange',
          icon: {
            className: 'material-icons',
            tagName: 'i',
            text: 'warning'
          }
        },
        {
          type: 'error',
          background: 'indianred',
          duration: 4000,
          dismissible: true
        },
        {
          type: 'success',
          background: '#36ad18',
        }
      ]
    });

    function mcFormat(text) {
      if (!text) return "";
      let result = "";
      let openTags = [];

      for (let i = 0; i < text.length; i++) {
        if (text[i] === "§" && i + 1 < text.length) {
          let code = text[i + 1].toLowerCase();
          i++;
          if (minecraft_colors[code]) {
            if (openTags.length) {
              result += "</span>";
              openTags.pop();
            }
            let style = `color:${minecraft_colors[code]};`;
            result += `<span style="${style}">`;
            openTags.push("color");
          } else if (minecraft_formats[code]) {
            if (code === 'r') {
              while (openTags.length) {
                result += "</span>";
                openTags.pop();
              }
            } else {
              let style = minecraft_formats[code];
              result += `<span style="${style}">`;
              openTags.push("format");
            }
          }
        } else {
          result += text[i];
        }
      }

      while (openTags.length) {
        result += "</span>";
        openTags.pop();
      }

      return result;
    }

    function enableSorting(listId, type) {
      new Sortable(document.getElementById(listId), {
        handle: ".drag-handle",
        animation: 150,
        onEnd: function (evt) {
          let current = evt.oldIndex + 1;
          let newChange = evt.newIndex + 1;

          let xhttp = new XMLHttpRequest();
          xhttp.open("GET", `./api/package_change.php?type=${type}&current=${current}&newChange=${newChange}`, true);
          xhttp.send();
        }
      });
    }

    function copyPathToClipboard(path) {
      navigator.clipboard.writeText(path).then(() => {
        notyf.success("Đường dẫn đã được sao chép vào clipboard!");
      }).catch(err => {
        notyf.error("Không thể sao chép đường dẫn: " + err);
      });
    }

    function getMinecraftVersion(version) {
      if (!version) return "Không xác định";
      return Array.isArray(version) ? version.join(".") : version;
    }

    function getAuthors(authors) {
      if (!authors || authors.length === 0) return "Không có tác giả.";
      if (Array.isArray(authors)) {
        return authors.map(author => `<a href="https://google.com/search?q=${encodeURIComponent("\"" + author + "\"")}" class="text-blue-500 hover:underline" target="_blank">${mcFormat(author)}</a>`).join(", ");
      }
      return undefined;
    }

    function getPackLink(metadata) {
      return metadata
        ? `<a class="text-blue-400 hover:underline" href="${metadata}">${metadata}</a>`
        : "Không có liên kết";
    }

    function showInfo(pack) {
      let xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          let data = JSON.parse(this.responseText);
          let header = data.header || {};
          let iconPath = data.icon || "default-icon.png";
          let metadata = data.metadata || {};

          let versionText = Array.isArray(header.version) ? header.version.join(".") : "Không xác định";
          let info = `
            <div class="p-4 bg-white dark:bg-gray-800 rounded-md flex items-center">
              <img src="${iconPath}" alt="Icon" class="w-40 h-40 mr-3 rounded-md">
              <div class="dark:text-gray-300">
                <h3 class="text-lg font-semibold mb-1 dark:text-white">${mcFormat(header.name || data.pack_id)}</h3>
                <p class="text-sm text-gray-700 dark:text-gray-400" style="line-height: 35px;"><strong>ID:</strong> ${header.uuid || "Không xác định"}</p>
                <hr class="dark:border-gray-600"/>
                <p class="text-sm text-gray-700 dark:text-gray-400" style="line-height: 35px;"><strong>Phiên bản:</strong> ${versionText}</p>
                <hr class="dark:border-gray-600"/>
                <p class="text-sm text-gray-700 dark:text-gray-400" style="line-height: 35px;"><strong>Mô tả:</strong> ${header.description || "Không có mô tả."}</p>
                <hr class="dark:border-gray-600"/>
                <p class="text-sm text-gray-700 dark:text-gray-400" style="line-height: 35px;"><strong>Tác giả:</strong> ${getAuthors(metadata.authors) || "Không có tác giả."}</p>
              </div>
            </div>
            <hr class="dark:border-gray-600"/>
            <div class="dark:text-gray-300">
              <p class="text-sm inline-block text-gray-700 dark:text-gray-400 mr-2" style="line-height: 35px;"><strong>Đường dẫn thư mục:</strong> ${data.path || "Không có đường dẫn."}</p>
              <button class="mr-2 px-3 inline-block py-1 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600 text-white text-sm rounded">
                Sao chép
              </button>
              <hr class="dark:border-gray-600"/>
              <p class="text-sm text-gray-700 dark:text-gray-400" style="line-height: 35px;"><strong>Phiên bản Minecraft tối thiểu:</strong> ${getMinecraftVersion(header.min_engine_version) || "Không xác định"}</p>
              <hr class="dark:border-gray-600"/>
              <p class="text-sm text-gray-700 dark:text-gray-400" style="line-height: 35px;"><strong>Luật bản quyền:</strong> ${metadata.license || "Không xác định"}</p>
              <hr class="dark:border-gray-600"/>
              <p class="text-sm text-gray-700 dark:text-gray-400" style="line-height: 35px;"><strong>Liên kết:</strong> ${getPackLink(metadata?.url)}</p>
            </div>
          `;

          let modal = document.createElement("div");
          modal.className = "fixed inset-0 bg-gray-800 dark:bg-gray-950 bg-opacity-50 dark:bg-opacity-70 flex items-center justify-center z-50";
          modal.innerHTML = `
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 max-w-[800px] w-full relative">
              <button id="closeModalBtn" class="absolute transition duration-200 top-4 right-4 text-sm text-gray-500 dark:text-gray-400 p-3 rounded-md w-10 h-10 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-700"><i class="fi fi-br-cross"></i></button>
              ${mcFormat(info)}
            </div>
          `;

          modal.style.opacity = 0;
          modal.style.transition = "opacity 0.2s ease";
          document.body.appendChild(modal);
          setTimeout(() => {
            modal.style.opacity = 1;
          }, 100);

          modal.querySelector("#closeModalBtn").addEventListener("click", () => {
            modal.style.transition = "opacity 0.2s ease";
            modal.style.opacity = 0;
            setTimeout(() => modal.remove(), 100);
          });
        }
      };

      xhttp.open("GET", `./api/package_info.php?uid=${encodeURIComponent(pack.uuid)}`, true);
      xhttp.send();
    }

    function loadAll() {
      let xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          let data = JSON.parse(this.responseText);
          renderList(data.resource, "resource_packs", true);
          renderList(data.behavior, "behavior_packs", true);
        }
      };
      xhttp.open("GET", "./api/package_all_list.php", true);
      xhttp.send();
    }

    function renderList(packs, targetId, isAll) {
      let container = document.getElementById(targetId);
      container.innerHTML = "";

      packs.forEach(p => {
        let icon = p.icon
          ? `<img src="${p.icon}" class="w-10 h-10 object-cover rounded-md">`
          : `<div class="w-10 h-10 bg-gray-300 dark:bg-gray-600 flex items-center justify-center rounded-md text-xs">No</div>`;
        let desc = isAll
          ? `(ID: ${p.uuid}) v${p.version.join(".")}`
          : `v${p.version.join(".")}`;

        let handle = isAll ? "" : `<span class="drag-handle cursor-move mr-2">⋮⋮</span>`;

        let div = document.createElement("div");
        div.className = "flex items-center bg-white/60 dark:bg-gray-700/60 rounded-lg shadow p-2";
        div.innerHTML = `
          ${handle}
          ${icon}
          <div class="ml-3 flex-1 dark:text-gray-100">
            <div class="text-sm font-semibold">${mcFormat(p.name || p.pack_id)}</div>
            <div class="text-xs text-gray-600 dark:text-gray-400">${mcFormat(desc)}</div>
          </div>
          <button id="info_button" class="ml-1 w-5 h-5 text-xs text-gray-500 dark:text-gray-400 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 rounded-full flex items-center justify-center">
            i
          </button>
          <button id="pack_button" class="ml-2 px-2 py-1 text-sm ${isAll ? 'bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600' : 'bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-600'} text-white rounded">
            ${isAll ? 'Thêm' : 'Gỡ'}
          </button>
        `;

        container.appendChild(div);

        let btn = div.querySelector("#pack_button");
        if (isAll) {
          btn.addEventListener("click", () => addPack(encodeURIComponent(JSON.stringify(p))));
        } else {
          btn.addEventListener("click", () => removePack(encodeURIComponent(JSON.stringify(p))));
        }

        let infoBtn = div.querySelector("#info_button");
        infoBtn.addEventListener("click", () => showInfo(p));
      });

      if (!isAll) {
        enableSorting(targetId, targetId.includes("resource") ? "resource" : "behavior");
      }
    }

    function loadAdded() {
      let xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          let data = JSON.parse(this.responseText);
          renderList(data.resource, "added_resource", false);
          renderList(data.behavior, "added_behavior", false);
        }
      };
      xhttp.open("GET", "./api/package_added_list.php", true);
      xhttp.send();
    }

    function addPack(data) {
      let xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          if (this.responseText.trim() == "true") {
            loadAdded();
            notyf.success("Gói đã được thêm vào.");
          } else if (this.responseText.trim() == "duplicated") {
            notyf.open({
              type: 'warn',
              message: 'Gói này đã tồn tại.'
            });
          } else {
            notyf.error("Không thể thêm gói này. Vui lòng thử lại sau.");
          }
        }
      };
      xhttp.open("GET", "./api/package_add.php?data=" + data, true);
      xhttp.send();
    }

    function removePack(data) {
      let xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          if (this.responseText.trim() == "true") {
            loadAdded();
            notyf.success("Gói đã được gỡ bỏ.");
          } else {
            notyf.error("Không thể gỡ bỏ gói này. Vui lòng thử lại sau.");
          }
        } else if (this.readyState == 4) {
          notyf.error("Lỗi khi gỡ bỏ gói: " + this.responseText);
        }
      };
      xhttp.open("GET", "./api/package_remove.php?data=" + data, true);
      xhttp.send();
    }

    loadAll();
    loadAdded();
  </script>
</body>
  <div class="debug-console">
    <style>
      .debug-console {
        position: absolute;
        bottom: 0;
        left: 0;
        z-index: 3000;
        background: #2e7520;
        width: 20px!important;
        height: 20px!important;
        overflow: hidden;
      }
    </style>
  </div>
</html>
