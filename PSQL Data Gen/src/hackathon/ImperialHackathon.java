/**

    FILENAME: resetdb.sql
    AUTHOR:   Peregrine Park
    DATE:     26.02.2012
    PROJECT:  Imperial College Hackathon 2012

**/

package hackathon;

import hackathon.datagen.Generator;
import hackathon.datagen.ItemGenerator;
import hackathon.datagen.PurchaseGenerator;
import hackathon.datagen.ShopGenerator;
import hackathon.util.FileUtils;

import java.io.IOException;

public class ImperialHackathon
{

    public static void main(String[] args) throws IOException
    {
        // Constants
        final int NUMBER_OF_PURCHASE_RECORDS = 15;
        final int NUMBER_OF_ITEMS = 3;
        final int NUMBER_OF_SHOPS = 1;

        final int NUMBER_OF_STUDENTS = 5;
        final int RANGE_OF_DAYS      = 3;

        // Result buffer
        StringBuffer buffer = new StringBuffer();
        Generator generator = null;

        // Purchase records
        generator = new PurchaseGenerator(NUMBER_OF_STUDENTS, NUMBER_OF_ITEMS,
                NUMBER_OF_SHOPS, RANGE_OF_DAYS);
        buffer.setLength(0);

        for(int i = 0; i < NUMBER_OF_PURCHASE_RECORDS; i++) {
            buffer.append(generator.generate());
        }

        FileUtils.outputBufferToFile("/Users/shared/purchases.csv", buffer);

        // Item records
        generator = new ItemGenerator(NUMBER_OF_ITEMS);
        buffer.setLength(0);

        for(int i = 0; i < NUMBER_OF_ITEMS; i++) {
            buffer.append(generator.generate());
        }

        FileUtils.outputBufferToFile("/Users/shared/items.csv", buffer);

        // Shop records
        generator = new ShopGenerator(NUMBER_OF_SHOPS);
        buffer.setLength(0);

        for(int i = 0; i < NUMBER_OF_SHOPS; i++) {
            buffer.append(generator.generate());
        }

        FileUtils.outputBufferToFile("/Users/shared/shops.csv", buffer);
    }

}
