function signOut() {
    if (confirm("Are you sure you want to sign out?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "signout.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert('Signed out successfully!');
                window.location.reload();
            }
        };
        xhr.send();
    }
}
