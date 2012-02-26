/**

    FILENAME: resetdb.sql
    AUTHOR:   Peregrine Park
    DATE:     26.02.2012
    PROJECT:  Imperial College Hackathon 2012

**/

package hackathon.util;

public class IntUtils
{

    public static int randomIntBetween(int lower, int upper)
    {
        return lower + (int)(Math.random() * ((upper - lower) + 1));
    }

}
