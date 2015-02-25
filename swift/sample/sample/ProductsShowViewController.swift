import UIKit

class ProductsShowViewController: UIViewController {
    
    var product: String = ""
    
    override func viewDidLoad() {
        super.viewDidLoad()
        title = product
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }
}
