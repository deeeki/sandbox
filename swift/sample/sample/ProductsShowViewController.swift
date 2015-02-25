import UIKit

class ProductsShowViewController: UIViewController {
    
    var product: String = ""
    
    override func viewDidLoad() {
        super.viewDidLoad()
        title = product
        let footerView = UIView(frame: CGRectMake(0, view.bounds.height - 50, view.bounds.width, 50))
        footerView.backgroundColor = UIColor.grayColor()
        view.addSubview(footerView)
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }
}
