module ActsAsArrayField
  def acts_as_array_field field
    class_eval %[
      def #{field.to_s}=(value)
        value = value.join(',') if value.is_a?(Array)
        write_attribute(:#{field}, value)
      end

      def #{field.to_s}
        read_attribute(:#{field}).split(',')
      end
    ]
  end
end

ActiveRecord::Base.__send__(:extend, ActsAsArrayField)
