/**

    FILENAME: resetdb.sql
    AUTHOR:   Peregrine Park
    DATE:     26.02.2012
    PROJECT:  Imperial College Hackathon 2012

**/

package hackathon.datagen;

import hackathon.util.IntUtils;

public class PurchaseGenerator implements Generator
{

    // Size of a day in UNIX time-stamp format (seconds)
    private final int DAY_SIZE = 24 * 60 * 60;

    // Constants defining the range of CIDs that can be generated
    private final int STARTING_CID = 169600;
    private final int ENDING_CID   = 169999;

    // The available CIDs to the generator
    private int[] availableCIDs;

    // Maximum item ID
    private int numberOfItems;

    // Maximum shop ID
    private int numberOfShops;

    // Range of days that can be assigned counting back from today
    private int rangeOfDays;

    public PurchaseGenerator(int numberOfCIDs, int numberOfItems, int numberOfShops, int rangeOfDays)
    {
        this.availableCIDs = new int[numberOfCIDs];
        this.numberOfItems = numberOfItems;
        this.numberOfShops = numberOfShops;
        this.rangeOfDays   = rangeOfDays;

        for(; numberOfCIDs > 0; numberOfCIDs--) {
            availableCIDs[numberOfCIDs - 1] = IntUtils.randomIntBetween(
                    STARTING_CID, ENDING_CID);
        }
    }

    @Override
    public String generate()
    {
        long timestamp = (long)(System.currentTimeMillis() / 1000) -
            IntUtils.randomIntBetween(0, rangeOfDays) * DAY_SIZE;
        int cidIndex = IntUtils.randomIntBetween(0, availableCIDs.length - 1);
        int itemId = IntUtils.randomIntBetween(1, numberOfItems);
        int shopId = IntUtils.randomIntBetween(1, numberOfShops);

        return "" + availableCIDs[cidIndex] + "," + itemId + "," +
            shopId + "," + timestamp + "\n";
    }

}
