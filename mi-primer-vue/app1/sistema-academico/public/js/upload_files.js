let state = { filesArr: [] };

// state management
function updateState(newState) {
	state = { ...state, ...newState };
	//console.log(state);
}

// event handlers
$("#upload").change(function (e) {
	let files = e.target.files;
	let filesArr = Array.from(files);
	updateState({ filesArr: [...state.filesArr, ...filesArr] });
	renderFileList();
});

$(".files").on("click", "li > i", function (e) {
	let key = $(this).parent().attr("key");
	let curArr = state.filesArr;
	curArr.splice(key, 1);
	updateState({ filesArr: curArr });
	renderFileList();
});

// render functions
function renderFileList() {
	let fileMap = state.filesArr.map((file, index) => {
		let suffix = "bytes";
		let size = file.size;
		if (size >= 1024 && size < 1024000) {
			suffix = "KB";
			size = Math.round((size / 1024) * 100) / 100;
		} else if (size >= 1024000) {
			suffix = "MB";
			size = Math.round((size / 1024000) * 100) / 100;
		}

		// Display a preview of images and PDFs
		let preview = "";
		if (file.type.includes("image")) {
			preview = `<img src="${URL.createObjectURL(
				file
			)}" class="file-preview" alt="${file.name}">`;
		}

		return `
                    <li class="fileUp" key="${index}">
                        ${file.name}
                        <span class="file-size">${size} ${suffix}</span>
                        ${preview}
                        <i class="preU fa fa-trash" aria-hidden="true"></i>
                    </li>
                `;
	});
	$("#previewF").html(fileMap);
}