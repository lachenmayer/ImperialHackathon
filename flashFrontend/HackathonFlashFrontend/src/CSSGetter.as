package  
{
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.TextEvent;
	import flash.net.URLLoader;
	import flash.net.URLRequest;
	import flash.text.StyleSheet;
	import flash.text.TextField;
	import flash.utils.ByteArray;
	/**
	 * ...
	 * @author Vojtech Havlicek
	 */
	public class CSSGetter extends EventDispatcher
	{
		
		private var loader:URLLoader;
		
		[Embed(source = "../lib/css/bootstrap-responsive.css", mimeType="application/octet-stream")]
		private var bar:Class

		[Embed(source = "../lib/css/style.css", mimeType="application/octet-stream")]
		private var bar2:Class
		
		private var b:ByteArray;
			
		public static var CSS:StyleSheet
		public static var CSSBootstrap:StyleSheet
		
		public function CSSGetter() 
		{
			
			CSSBootstrap = new StyleSheet();
			b = new bar() as ByteArray;			
			CSSBootstrap.parseCSS(b.toString());
			
			CSS = new StyleSheet();
			b = new bar2() as ByteArray;	
			CSS.parseCSS(b.toString());
			
			
			
			
		}
		
		
		
  
	}

}