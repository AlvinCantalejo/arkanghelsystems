class TableHelper {
    static addData (content) {
        return "<td>" + content + "</td>";
    }
    
    static addButton (content) {
        return "<td style='text-align: center;'>" + content + "</td>";
    }
}
export default TableHelper