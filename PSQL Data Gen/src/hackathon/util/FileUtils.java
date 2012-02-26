/**

    FILENAME: resetdb.sql
    AUTHOR:   Peregrine Park
    DATE:     26.02.2012
    PROJECT:  Imperial College Hackathon 2012

**/

package hackathon.util;

import java.io.FileOutputStream;
import java.io.IOException;

public class FileUtils
{

    public static void outputBufferToFile(String path, StringBuffer buffer)
        throws IOException
    {
        FileOutputStream output = new FileOutputStream(path);
        output.write(buffer.toString().getBytes());
        output.close();
    }

}
