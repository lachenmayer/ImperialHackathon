/**

    FILENAME: resetdb.sql
    AUTHOR:   Peregrine Park
    DATE:     26.02.2012
    PROJECT:  Imperial College Hackathon 2012

**/

package hackathon.datagen;

import hackathon.util.IntUtils;

public class ItemGenerator implements Generator
{

    // Max price an item can have
    private final int MAX_ITEM_PRICE = 50000;

    // Maximum number of items
    private int maxItems;

    // Current item ID
    private int currentItem;

    public ItemGenerator(int maxItems)
    {
        this.maxItems    = maxItems;
        this.currentItem = 0;
    }

    @Override
    public String generate()
    {
        if(currentItem++ > maxItems) {
            return "\n";
        } else {
            return "" + currentItem + ",\"item" + currentItem + "\"," +
                IntUtils.randomIntBetween(1, MAX_ITEM_PRICE) +
                ",\"metadata\"\n";
        }
    }

}
