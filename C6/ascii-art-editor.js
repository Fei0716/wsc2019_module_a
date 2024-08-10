/**
 * JavaScript - ASCII Art Editor
 *
 * Your task is to implement all methods marked with @todo. You must not change any other method.
 * You may add as many methods to the ASCIIArtEditor class as you want.
 */


/**
 * Constructor function to create a new ASCIIArtEditor
 * @constructor
 */
var ASCIIArtEditor = function () {
    /**
     * When transforming images this property should be used as line
     * separator for all operations
     * @type {string}
     */
    this.lineSeperator = '\n';
};


/**
 * This function takes an arbitrary ASCII Art string as input and must
 * return a mirrored version of the given image.
 *
 * It should be possible to choose the mirror-axis with the second argument.
 *
 * The function should use the configured lineSeparator property on
 * the ASCIIArtEditor object.
 *
 * Example on 'x' axis:
 *   Input:                 Output:
 *     # --····-- $           # --====-- $
 *     #  +    -  $           #  +    -  $
 *     # --====-- $           # --····-- $
 *
 * Example on 'y' axis:
 *   Input:                 Output:
 *     # --····-- $           $ --····-- #
 *     #  +    -  $           $  -    +  #
 *     # --====-- $           $ --====-- #
 *
 * @param {string} image - the source image
 * @param {'x'|'y'} [axis='y'] - the axis to be used for the mirror operation, defaults to 'y'
 * @return string - the mirrored input image
 *
 * @throws Error - If an invalid axis was provided
 *
 * @todo
 */
ASCIIArtEditor.prototype.mirror = function (image, axis) {
    // <---- Implement this method
    if(!["x" , "y"].includes(axis)){
        throw Error("FK off");
    }
    if(axis === "x"){
        let stringArr = image.replaceAll('\r' ,'').split("\n");

        //use two pointer method
        let high = stringArr.length - 1;
        let low = 0;
        let temp = '';
        while(low < high){
            //swap the values
            temp  = stringArr[low];
            stringArr[low]  = stringArr[high];
            stringArr[high] = temp;

            high--;low++;
        }
        return stringArr.join('\n');
    }else{
        let stringArr = image.split("\n");
        //use two pointer method
        // Convert each row from a string to an array of characters
        let rows = stringArr.map(row => row.split(''));

        // Use two pointer method
        let high = rows[0].length - 1;
        let low = 0;
        let rowCount = rows.length;

        while (low < high) {
            // Swap the values in each row
            for (let i = 0; i < rowCount; i++) {
                // Swap elements vertically
                let temp = rows[i][high];
                rows[i][high] = rows[i][low];
                rows[i][low] = temp;
            }

            high--;
            low++;
        }

        // Convert each row back to a string and join them
        let result = rows.map(row => row.join('')).join('\n');

        return result;

    }

};


/**
 * Takes any SQUARE ASCII image and must rotate the image by the
 * given angle (only multiple of 90 allowed).
 *
 * The rotation should always be clockwise.
 *
 * Example:
 *   Input:    90deg:    180deg:    270deg:    360deg:
 *     #-*       $-#       *-$        ***         #-*
 *     --*       ---       *--        ---         --*
 *     $-*       ***       *-#        #-$         $-*
 *
 * @param {string} image
 * @param {number} angle, has to be one of 0, 90, 180, 270, 360
 * @return string
 *
 * @throws Error - If an invalid angle was provided
 *
 * @todo
 */
ASCIIArtEditor.prototype.rotate = function(image, angle) {
    // <---- Implement this method
    let angles = [0, 90, 180, 270, 360];
    if(!angles.includes(parseInt(angle))){
        throw Error("FK off");
    }
    let rotateCount = angles.findIndex((a) => a=== parseInt(angle));

    let count = 0;
    let output = image.split('\n');

    let rows =  output.map((row)=> row.split(''));
    let newArr = [];
    let temp = [];
    while(count < rotateCount){
        //switch columns with rows
        //i = cols
        newArr  = []
        for(let i = 0; i < rows[0].length; i++){
            temp = [];
            //j = rows
            for(let j = rows.length - 1; j >= 0 ; j--){
                // debugger
                temp.push(rows[j][i]);
            }
            newArr.push(temp);
        }
        rows = newArr;
        count++;
    }

    // Convert each row back to a string and join them
    let result = rows.map(row => row.join('')).join('\n');

    return result;
};
