class CookieClass {
    /**
     * 
     * */
    static setCookie (
        name, // unique for the cookie
        value, // value to be stored
        days = 1 // length in DAY before it gets deleted
    ) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + days*24*60*60*1000); 
            var expires = "; expires=" + date.toGMTString(); 
        }
        else {
            var expires = "";
        }
            
        document.cookie = name+"=" + value+expires + ";path=/";
    }
        
    static getCookie (name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    static createCookie (data, days = 1) {
        let value;
        for(var key in data){
            value = data[key];
            if (days){
                var date = new Date();
                date.setTime(date.getTime() + days*24*60*60*1000);
                var expires = "; expires=" + date.toGMTString();
            }
            else
                var expires = "";
                document.cookie = key + "=" + value + expires + ";path=/";
            
        }
    }
    
    static deleteAllCookies () {
        var cookies = document.cookie.split(";");
    
        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i];
            var eqPos = cookie.indexOf("=");
            var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
            document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
        }
    }
   
}
export default CookieClass 