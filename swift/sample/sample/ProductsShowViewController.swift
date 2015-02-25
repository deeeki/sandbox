import UIKit

class ProductsShowViewController: UIViewController {
    
    var product: String = ""
    
    override func viewDidLoad() {
        super.viewDidLoad()
        title = product
        let addButton = UIButton(frame: CGRectMake(view.bounds.width - 100, 0, 100, 50))
        addButton.setTitle("Add", forState: .Normal)
        addButton.backgroundColor = UIColor.blueColor()
        addButton.addTarget(self, action: "add:", forControlEvents: .TouchUpInside)
        let footerView = UIView(frame: CGRectMake(0, view.bounds.height - 50, view.bounds.width, 50))
        footerView.backgroundColor = UIColor.grayColor()
        footerView.addSubview(addButton)
        view.addSubview(footerView)
        let label = UILabel(frame: CGRectMake(0, 50, view.bounds.width, 50))
        label.text = product
        view.addSubview(label)
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }

    func add(sender: AnyObject) {
        navigationController?.popViewControllerAnimated(true)
    }
}
