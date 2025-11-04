//JavaScript
document.addEventListener("DOMContentLoaded", function () {
    const treeElement = document.getElementById('tree');
    if (!treeElement || typeof FamilyTree === 'undefined') {
        return;
    }

    var options = getOptions();

    var family = new FamilyTree(treeElement, {
        mouseScrool: FamilyTree.none,
        scaleInitial: options.scaleInitial,
        mode: 'dark',
        template: 'hugo',
        roots: [1],
        nodeMenu: {
            // edit: { text: 'Edit' },
            details: { text: 'Details' },
        },
        // nodeTreeMenu: true,
        nodeBinding: {
            field_0: 'name',
            field_1: 'born',
            img_0: 'photo'
        },
        // editForm: {
        //     titleBinding: "name",
        //     photoBinding: "photo",
        //     addMoreBtn: 'Add element',
        //     addMore: 'Add more elements',
        //     addMoreFieldName: 'Element name',
        //     generateElementsFromFields: false,
        //     elements: [
        //         { type: 'textbox', label: 'Full Name', binding: 'name' },
        //         { type: 'textbox', label: 'Email Address', binding: 'email' },
        //         [
        //             { type: 'textbox', label: 'Phone', binding: 'phone' },
        //             { type: 'date', label: 'Date Of Birth', binding: 'born' }
        //         ],
        //         [
        //             { type: 'textbox', label: 'Country', binding: 'country' },
        //             { type: 'textbox', label: 'City', binding: 'city' },
        //         ],
        //         { type: 'textbox', label: 'Photo Url', binding: 'photo', btn: 'Upload' },
        //     ]
        // },
    });

    family.on('field', function (sender, args) {
        if (args.name == 'born') {
            var date = new Date(args.value);
            args.value = date.toLocaleDateString();
        }
    });

    // Fetch data from Laravel route
    fetch("/family-data")
        .then(response => response.json())
        .then(data => {
            console.log("Family data:", data); // Debug, optional

            // Load into family tree
            family.load(data);
        })
        .catch(error => {
            console.error("Error fetching family data:", error);
        });
});

// family.load(
//     [
//         { id: 1, gender: 'male', photo: 'https://cdn.balkan.app/shared/m60/2.jpg', name: 'Zeph Daniels', born: '1954-09-29', pids: [3] },
//         { id: 2, gender: 'male', photo: 'https://cdn.balkan.app/shared/m60/1.jpg', name: 'Rowan Annable', born: '1952-10-10', pids: [3] },
//         { id: 3, gender: 'female', photo: 'https://cdn.balkan.app/shared/w60/1.jpg', name: 'Laura Shepherd', born: '1943-01-13', email: 'laura.shepherd@gmail.com', phone: '+44 845 5752 547', city: 'Moscow', country: 'ru', pids: [1, 2] },
//         { id: 4, photo: 'https://cdn.balkan.app/shared/m60/3.jpg', name: 'Rowan Annable', pids: [5] },
//         { id: 5, gender: 'female', photo: 'https://cdn.balkan.app/shared/w60/3.jpg', name: 'Lois Sowle', pids: [4] },
//         { id: 6, gender: 'female', photo: 'https://cdn.balkan.app/shared/w30/1.jpg', name: 'Tyler Heath', born: '1975-11-12', mid: 2, fid: 3, pids: [7] },
//         { id: 7, pids: [6], mid: 5, fid: 4, gender: 'male', photo: 'https://cdn.balkan.app/shared/m30/3.jpg', name: 'Samson Stokes', born: '1986-10-01' },
//         { id: 8, mid: 7, fid: 6, gender: 'female', photo: 'https://cdn.balkan.app/shared/w10/3.jpg', name: 'Celeste Castillo', born: '2021-02-01' },
//         { id: 9, mid: 7, fid: 6, gender: 'male', photo: 'https://cdn.balkan.app/shared/m10/3.jpg', name: 'Zachary Stokes', born: '2019-05-12' }
//     ]
// );

function getOptions(){
    const searchParams = new URLSearchParams(window.location.search);
    var fit = searchParams.get('fit');
    var enableSearch = true;
    var scaleInitial = 1;
    if (fit == 'yes'){
        enableSearch = false;
        scaleInitial = FamilyTree.match.boundary;
    }
    return {enableSearch, scaleInitial};
}
