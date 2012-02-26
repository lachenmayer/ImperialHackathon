/**

    FILENAME: resetdb.sql
    AUTHOR:   Peregrine Park
    DATE:     26.02.2012
    PROJECT:  Imperial College Hackathon 2012

**/

package hackathon.datagen;

public class ShopGenerator implements Generator
{

    // Maximum number of shops
    private int maxShops;

    // Current shop ID
    private int currentShop;

    public ShopGenerator(int maxShops)
    {
        this.maxShops    = maxShops;
        this.currentShop = 0;
    }

    @Override
    public String generate()
    {
        if(currentShop++ > maxShops) {
            return "\n";
        } else {
            return "" + currentShop + ",\"shop" + currentShop + "\"\n";
        }
    }

}
